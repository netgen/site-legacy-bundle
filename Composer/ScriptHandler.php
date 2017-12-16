<?php

namespace Netgen\Bundle\MoreLegacyBundle\Composer;

use Composer\Script\Event;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler as DistributionBundleScriptHandler;

class ScriptHandler extends DistributionBundleScriptHandler
{
    /**
     * Symlinks legacy siteaccesses and various other legacy files to their proper locations.
     *
     * @param $event \Composer\Script\Event
     */
    public static function installLegacySymlinks(Event $event)
    {
        $options = static::getOptions($event);
        $consoleDir = static::getConsoleDir($event, 'install legacy symlinks');

        static::executeCommand($event, $consoleDir, 'ngmore:symlink:legacy', $options['process-timeout']);
    }
}
