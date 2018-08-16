<?php

declare(strict_types=1);

namespace Netgen\Bundle\MoreLegacyBundle\LegacyMapper;

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

    /**
     * @var array
     */
    protected $enabledLegacySettings;

    public function __construct(ConfigResolverInterface $configResolver, array $enabledLegacySettings)
    {
        $this->configResolver = $configResolver;
        $this->enabledLegacySettings = $enabledLegacySettings;
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
        $injectedSettings = $this->configResolver->getParameter('injected_settings', 'netgen_more_legacy');
        $injectedMergeSettings = $this->configResolver->getParameter('injected_merge_settings', 'netgen_more_legacy');

        $formattedInjectedSettings = [];
        $formattedInjectedMergeSettings = [];

        foreach ($this->enabledLegacySettings as $legacyIniName) {
            if (!empty($injectedSettings[$legacyIniName]) && is_array($injectedSettings[$legacyIniName])) {
                foreach ($injectedSettings[$legacyIniName] as $legacyIniValueName => $legacyIniValue) {
                    if (!is_string($legacyIniValueName)) {
                        continue;
                    }

                    $formattedInjectedSettings[$legacyIniName . '/' . $legacyIniValueName] = $legacyIniValue;
                }
            }

            if (!empty($injectedMergeSettings[$legacyIniName]) && is_array($injectedMergeSettings[$legacyIniName])) {
                foreach ($injectedMergeSettings[$legacyIniName] as $legacyIniValueName => $legacyIniValue) {
                    if (!is_string($legacyIniValueName)) {
                        continue;
                    }

                    if (is_array($legacyIniValue)) {
                        $formattedInjectedMergeSettings[$legacyIniName . '/' . $legacyIniValueName] = $legacyIniValue;
                    }
                }
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
