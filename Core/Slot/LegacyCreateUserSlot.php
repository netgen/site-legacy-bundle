<?php

declare(strict_types=1);

namespace Netgen\Bundle\MoreLegacyBundle\Core\Slot;

use eZ\Publish\Core\MVC\Legacy\SignalSlot\AbstractLegacySlot;
use eZ\Publish\Core\SignalSlot\Signal;
use eZContentCacheManager;
use eZContentObject;
use eZContentOperationCollection;

class LegacyCreateUserSlot extends AbstractLegacySlot
{
    public function receive(Signal $signal): void
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
