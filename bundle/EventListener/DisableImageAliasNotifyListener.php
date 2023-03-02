<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\EventListener;

use eZ\Publish\Core\MVC\Legacy\Event\PreBuildKernelEvent;
use eZ\Publish\Core\MVC\Legacy\LegacyEvents;
use ezpEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DisableImageAliasNotifyListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [LegacyEvents::PRE_BUILD_LEGACY_KERNEL => ['onBuildKernel', 120]];
    }

    public function onBuildKernel(PreBuildKernelEvent $event): void
    {
        $ezpEvent = ezpEvent::getInstance();

        (function () {
            unset($this->listeners['image/removeAliases'], $this->listeners['image/trashAliases'], $this->listeners['image/purgeAliases']);
        })->call($ezpEvent);
    }
}
