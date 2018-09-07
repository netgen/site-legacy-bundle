<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\LegacyMapper;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Legacy\Event\PreBuildKernelEvent;
use eZ\Publish\Core\MVC\Legacy\LegacyEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Configuration implements EventSubscriberInterface
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    protected $configResolver;

    public function __construct(ConfigResolverInterface $configResolver)
    {
        $this->configResolver = $configResolver;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LegacyEvents::PRE_BUILD_LEGACY_KERNEL => ['onBuildKernel', 64],
        ];
    }

    /**
     * Adds settings to the parameters that will be injected into the legacy kernel.
     */
    public function onBuildKernel(PreBuildKernelEvent $event): void
    {
        $injectedSettings = $this->configResolver->getParameter('injected_settings', 'netgen_site_legacy');
        $injectedMergeSettings = $this->configResolver->getParameter('injected_merge_settings', 'netgen_site_legacy');

        $formattedInjectedSettings = [];
        $formattedInjectedMergeSettings = [];

        foreach ($injectedSettings as $legacyIniName => $legacyIniConfig) {
            if (!is_array($legacyIniConfig) || empty($legacyIniConfig)) {
                continue;
            }

            foreach ($legacyIniConfig as $legacyIniValueName => $legacyIniValue) {
                if (!is_string($legacyIniValueName)) {
                    continue;
                }

                $formattedInjectedSettings[$legacyIniName . '/' . $legacyIniValueName] = $legacyIniValue;
            }
        }

        foreach ($injectedMergeSettings as $legacyIniName => $legacyIniConfig) {
            if (!is_array($legacyIniConfig) || empty($legacyIniConfig)) {
                continue;
            }

            foreach ($injectedMergeSettings[$legacyIniName] as $legacyIniValueName => $legacyIniValue) {
                if (!is_string($legacyIniValueName) || !is_array($legacyIniValue)) {
                    continue;
                }

                $formattedInjectedMergeSettings[$legacyIniName . '/' . $legacyIniValueName] = $legacyIniValue;
            }
        }

        $event->getParameters()->set(
            'injected-settings',
            $formattedInjectedSettings + (array) $event->getParameters()->get('injected-settings')
        );

        $event->getParameters()->set(
            'injected-merge-settings',
            $formattedInjectedMergeSettings + (array) $event->getParameters()->get('injected-merge-settings')
        );
    }
}
