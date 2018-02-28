<?php

declare(strict_types=1);

namespace Netgen\Bundle\MoreLegacyBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class NetgenMoreLegacyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('templating.yml');
        $loader->load('services.yml');
        $loader->load('view.yml');

        $processor = new ConfigurationProcessor($container, 'netgen_more_legacy');

        $processor->mapConfigArray('injected_settings', $config, ContextualizerInterface::MERGE_FROM_SECOND_LEVEL);
        $processor->mapConfigArray('injected_merge_settings', $config, ContextualizerInterface::MERGE_FROM_SECOND_LEVEL);

        $container->setParameter('ngmore_legacy.legacy_mapper.enabled_legacy_settings', $config['enabled_legacy_settings']);
    }
}
