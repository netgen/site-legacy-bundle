<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\Command;

use DirectoryIterator;
use Netgen\Bundle\SiteBundle\NetgenSiteProjectBundleInterface;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\KernelInterface;

use function basename;
use function date;
use function dirname;
use function file_get_contents;
use function in_array;
use function is_dir;
use function is_file;
use function is_link;
use function mb_strpos;
use function md5;
use function realpath;
use function str_replace;
use function strrev;

class SymlinkLegacyCommand extends Command
{
    /**
     * If true, command will destroy existing symlinks before recreating them.
     */
    protected bool $forceSymlinks = false;

    /**
     * The list of folders available in standard distribution of eZ Publish Legacy.
     */
    protected static array $legacyDistFolders = [
        'autoload',
        'benchmarks',
        'bin',
        'cronjobs',
        'design',
        'doc',
        'extension',
        'kernel',
        'lib',
        'schemas',
        'settings',
        'share',
        'support',
        'templates',
        'tests',
        'update',
        'var',
    ];

    /**
     * Files/directories that will not be symlinked in root and root_* folders.
     *
     * P.S. "settings" folder has special handling anyways
     */
    protected static array $blacklistedItems = [
        'settings',
    ];

    protected KernelInterface $kernel;

    protected Filesystem $fileSystem;

    protected string $legacyRootDir;

    public function __construct(KernelInterface $kernel, Filesystem $fileSystem, string $legacyRootDir)
    {
        $this->kernel = $kernel;
        $this->fileSystem = $fileSystem;
        $this->legacyRootDir = $legacyRootDir;

        // Parent constructor call is mandatory for commands registered as services
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('force', null, InputOption::VALUE_NONE, 'If set, it will destroy existing symlinks before recreating them');
        $this->setDescription('Symlinks legacy siteaccesses and various other legacy files to their proper locations');
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $this->forceSymlinks = (bool) $input->getOption('force');

        $legacyExtensions = [];

        foreach ($this->kernel->getBundles() as $bundle) {
            if (!$bundle instanceof NetgenSiteProjectBundleInterface) {
                continue;
            }

            if (!$this->fileSystem->exists($bundle->getPath() . '/ezpublish_legacy/')) {
                continue;
            }

            foreach (new DirectoryIterator($bundle->getPath() . '/ezpublish_legacy/') as $item) {
                if (!$item->isDir() || $item->isDot()) {
                    continue;
                }

                if (!$this->fileSystem->exists($item->getPathname() . '/extension.xml')) {
                    continue;
                }

                $legacyExtensions[] = $item->getPathname();
            }
        }

        if ($this->fileSystem->exists($this->kernel->getProjectDir() . '/src/ezpublish_legacy/')) {
            foreach (new DirectoryIterator($this->kernel->getProjectDir() . '/src/ezpublish_legacy/') as $item) {
                if (!$item->isDir() || $item->isDot()) {
                    continue;
                }

                if (!$this->fileSystem->exists($item->getPathname() . '/extension.xml')) {
                    continue;
                }

                $legacyExtensions[] = $item->getPathname();
            }
        }

        foreach ($legacyExtensions as $legacyExtension) {
            $this->symlinkLegacyExtensionSiteAccesses($legacyExtension, $output);
            $this->symlinkLegacyExtensionOverride($legacyExtension, $output);
            $this->symlinkLegacyExtensionFiles($legacyExtension, $output);
        }

        return 0;
    }

    /**
     * Symlinks siteccesses from a legacy extension.
     */
    protected function symlinkLegacyExtensionSiteAccesses(string $legacyExtensionPath, OutputInterface $output): void
    {
        /** @var \DirectoryIterator[] $directories */
        $directories = [];

        $path = $legacyExtensionPath . '/root_' . $this->kernel->getEnvironment() . '/settings/siteaccess/';
        if ($this->fileSystem->exists($path)) {
            $directories[] = new DirectoryIterator($path);
        }

        $path = $legacyExtensionPath . '/root/settings/siteaccess/';
        if ($this->fileSystem->exists($path)) {
            $directories[] = new DirectoryIterator($path);
        }

        $processedSiteAccesses = [];
        foreach ($directories as $directory) {
            foreach ($directory as $item) {
                if (!$item->isDir() || $item->isDot()) {
                    continue;
                }

                // We want root_* to have priority, so any siteaccess which we already "processed" will be skipped
                if (!in_array($item->getBasename(), $processedSiteAccesses, true)) {
                    $this->verifyAndSymlinkDirectory(
                        $item->getPathname(),
                        $this->legacyRootDir . '/settings/siteaccess/' . $item->getBasename(),
                        $output,
                    );

                    $processedSiteAccesses[] = $item->getBasename();
                }
            }
        }
    }

    /**
     * Symlinks override folder from a legacy extension.
     */
    protected function symlinkLegacyExtensionOverride(string $legacyExtensionPath, OutputInterface $output): void
    {
        // If settings/override folder exists in "root_*", obviously we cannot use the one in "root",
        // even if it exists. Thus, we only do fallback to "root/settings/override" if the folder in
        // "root_*" does not exist or is not a directory

        $sourceFolder = $legacyExtensionPath . '/root_' . $this->kernel->getEnvironment() . '/settings/override';
        if (!$this->fileSystem->exists($sourceFolder) || !is_dir($sourceFolder)) {
            $sourceFolder = $legacyExtensionPath . '/root/settings/override';
            if (!$this->fileSystem->exists($sourceFolder) || !is_dir($sourceFolder)) {
                return;
            }
        }

        $this->verifyAndSymlinkDirectory($sourceFolder, $this->legacyRootDir . '/settings/override', $output);
    }

    /**
     * Symlinks files from a legacy extension.
     */
    protected function symlinkLegacyExtensionFiles(string $legacyExtensionPath, OutputInterface $output): void
    {
        /** @var \DirectoryIterator[] $directories */
        $directories = [];

        $path = $legacyExtensionPath . '/root_' . $this->kernel->getEnvironment() . '/';
        if ($this->fileSystem->exists($path) && is_dir($path)) {
            $directories[] = new DirectoryIterator($path);
        }

        $path = $legacyExtensionPath . '/root/';
        if ($this->fileSystem->exists($path) && is_dir($path)) {
            $directories[] = new DirectoryIterator($path);
        }

        foreach ($directories as $directory) {
            foreach ($directory as $item) {
                if ($item->isDot() || $item->isLink()) {
                    continue;
                }

                if ($item->isDir() && in_array($item->getBasename(), self::$legacyDistFolders, true)) {
                    if (in_array($item->getBasename(), self::$blacklistedItems, true)) {
                        continue;
                    }

                    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($item->getPathname())) as $subItem) {
                        /** @var \SplFileInfo $subItem */
                        if ($subItem->isFile() && !$subItem->isLink()) {
                            if (in_array($subItem->getBasename(), self::$blacklistedItems, true)) {
                                continue;
                            }

                            // Allow filename to have .patched at the end of string (dehctap. in reverse file name)
                            // to work around eZ legacy autoload generator warning about duplicate class names
                            $fileName = $subItem->getBasename();
                            if (mb_strpos(strrev($fileName), 'dehctap.') === 0) {
                                $fileName = str_replace('.patched', '', $fileName);
                            }

                            $filePath = $this->fileSystem->makePathRelative(
                                realpath($subItem->getPath()),
                                $directory->getPath(),
                            ) . $fileName;

                            $filePath = $this->legacyRootDir . '/' . $filePath;

                            if ($this->fileSystem->exists($filePath) && is_file($filePath) && !is_link($filePath)) {
                                // If the destination is a real file, we'll just overwrite it, with backup
                                // but only if it differs from the original
                                if (md5(file_get_contents($subItem->getPathname())) === md5(file_get_contents($filePath))) {
                                    continue;
                                }

                                $this->fileSystem->copy($filePath, $filePath . '.backup.' . date('Y-m-d-H-i-s'), true);
                                $this->fileSystem->copy($subItem->getPathname(), $filePath, true);
                            } elseif (!$this->fileSystem->exists($filePath) || is_link($filePath)) {
                                $this->verifyAndSymlinkFile(
                                    $subItem->getPathname(),
                                    $filePath,
                                    $output,
                                );
                            }
                        }
                    }
                } elseif ($item->isDir() || $item->isFile()) {
                    if (in_array($item->getBasename(), self::$blacklistedItems, true)) {
                        continue;
                    }

                    $destination = $this->legacyRootDir . '/' . $item->getBasename();

                    if ($item->isDir()) {
                        $this->verifyAndSymlinkDirectory(
                            $item->getPathname(),
                            $destination,
                            $output,
                        );
                    } else {
                        $this->verifyAndSymlinkFile(
                            $item->getPathname(),
                            $destination,
                            $output,
                        );
                    }
                }
            }
        }
    }

    /**
     * Verify that source file can be symlinked to destination and do symlinking if it can.
     */
    protected function verifyAndSymlinkFile(string $source, string $destination, OutputInterface $output): void
    {
        if (!$this->fileSystem->exists(dirname($destination))) {
            $this->fileSystem->mkdir(dirname($destination), 0755);
        }

        if ($this->fileSystem->exists($destination) && !is_file($destination)) {
            $output->writeln('<comment>' . basename($destination) . '</comment> already exists in <comment>' . dirname($destination) . '/</comment> and is not a file/symlink. Skipping...');

            return;
        }

        if ($this->forceSymlinks && is_link($destination)) {
            $this->fileSystem->remove($destination);
        }

        if (is_file($destination) && !is_link($destination)) {
            if ($this->fileSystem->exists($destination . '.original')) {
                $output->writeln('Cannot create backup file <comment>' . basename($destination) . '.original</comment> in <comment>' . dirname($destination) . '/</comment>. Skipping...');

                return;
            }

            $this->fileSystem->rename($destination, $destination . '.original');
        }

        if ($this->fileSystem->exists($destination)) {
            if (is_link($destination)) {
                $output->writeln('Skipped creating the symlink for <comment>' . basename($destination) . '</comment> in <comment>' . dirname($destination) . '/</comment>. Symlink already exists!');
            } else {
                $output->writeln('Skipped creating the symlink for <comment>' . basename($destination) . '</comment> in <comment>' . dirname($destination) . '/</comment> due to an unknown error.');
            }

            return;
        }

        $this->fileSystem->symlink(
            $this->fileSystem->makePathRelative(
                dirname($source),
                realpath(dirname($destination)),
            ) . basename($source),
            $destination,
        );
    }

    /**
     * Verify that source directory can be symlinked to destination and do symlinking if it can.
     */
    protected function verifyAndSymlinkDirectory(string $source, string $destination, OutputInterface $output): void
    {
        if ($this->fileSystem->exists($destination) && !is_link($destination)) {
            $output->writeln('<comment>' . basename($destination) . '</comment> already exists in <comment>' . dirname($destination) . '/</comment> and is not a symlink. Skipping...');

            return;
        }

        if ($this->forceSymlinks && is_link($destination)) {
            $this->fileSystem->remove($destination);
        }

        if ($this->fileSystem->exists($destination)) {
            $output->writeln('Skipped creating the symlink for <comment>' . basename($destination) . '</comment> in <comment>' . dirname($destination) . '/</comment>. Symlink already exists!');

            return;
        }

        $this->fileSystem->symlink(
            $this->fileSystem->makePathRelative(
                $source,
                realpath(dirname($destination)),
            ),
            $destination,
        );
    }
}
