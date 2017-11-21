<?php

namespace Netgen\Bundle\MoreLegacyBundle\Composer;

use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as DistributionBundleScriptHandler;
use Composer\Script\Event;

class ScriptHandler extends DistributionBundleScriptHandler
{
    /**
     * Symlinks legacy siteaccesses and various other legacy files to their proper locations.
     *
     * @param $event \Composer\Script\Event
     */
    public static function installLegacySymlinks(Event $event)
    {
        $options = self::getOptions($event);
        $binDir = $options['symfony-bin-dir'];

        if (!is_dir($binDir)) {
            echo 'The symfony-bin-dir (' . $binDir . ') specified in composer.json was not found in ' . getcwd() . ', can not install legacy symlinks.' . PHP_EOL;

            return;
        }

        static::executeCommand($event, $binDir, 'ngmore:symlink:legacy', $options['process-timeout']);
    }
}
