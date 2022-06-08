<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\DependencyInjection;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class NetgenSiteLegacyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('templating.yml');
        $loader->load('services.yml');
        $loader->load('view.yml');

        $processor = new ConfigurationProcessor($container, 'netgen_site_legacy');

        $container->setParameter('netgen_site_legacy.default.injected_settings', []);
        $container->setParameter('netgen_site_legacy.default.injected_merge_settings', []);

        $processor->mapConfigArray('injected_settings', $config, ContextualizerInterface::MERGE_FROM_SECOND_LEVEL);
        $processor->mapConfigArray('injected_merge_settings', $config, ContextualizerInterface::MERGE_FROM_SECOND_LEVEL);
    }
}
