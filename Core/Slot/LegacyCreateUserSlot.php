<?php

namespace Netgen\Bundle\MoreLegacyBundle\Core\Slot;

use eZ\Publish\Core\SignalSlot\Signal;
use eZ\Publish\Core\MVC\Legacy\SignalSlot\AbstractLegacySlot;
use eZContentCacheManager;
use eZContentOperationCollection;
use eZContentObject;

class LegacyCreateUserSlot extends AbstractLegacySlot
{
    /**
     * Receive the given $signal and react on it.
     *
     * @param \eZ\Publish\Core\SignalSlot\Signal $signal
     */
    public function receive(Signal $signal)
    {
        if (!$signal instanceof Signal\UserService\CreateUserSignal) {
            return;
        }

        $this->runLegacyKernelCallback(
            function () use ($signal) {
                eZContentCacheManager::clearContentCacheIfNeeded($signal->userId);
                eZContentOperationCollection::registerSearchObject($signal->userId);
                eZContentObject::clearCache();
            }
        );
    }
}
