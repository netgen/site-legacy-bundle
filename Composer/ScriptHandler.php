<?php

namespace Netgen\Bundle\MoreLegacyBundle\Composer;

use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as DistributionBundleScriptHandler;
use Composer\Script\CommandEvent;
use Symfony\Component\Process\ProcessBuilder;

class ScriptHandler extends DistributionBundleScriptHandler
{
    /**
     * Symlinks legacy siteaccesses and various other legacy files to their proper locations.
     *
     * @param $event \Composer\Script\CommandEvent
     */
    public static function installLegacySymlinks(CommandEvent $event)
    {
        $options = self::getOptions($event);
        $appDir = $options['symfony-app-dir'];

        if (!is_dir($appDir)) {
            echo 'The symfony-app-dir (' . $appDir . ') specified in composer.json was not found in ' . getcwd() . ', can not install legacy symlinks.' . PHP_EOL;

            return;
        }

        static::executeCommand($event, $appDir, 'ngmore:symlink:legacy', $options['process-timeout']);
    }
}
