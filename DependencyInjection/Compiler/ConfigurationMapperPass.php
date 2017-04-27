<?php

namespace Netgen\Bundle\MoreLegacyBundle\DependencyInjection\Compiler;

use Netgen\Bundle\MoreLegacyBundle\LegacyMapper\LegacyConfiguration;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ConfigurationMapperPass implements CompilerPassInterface
{
    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->has('ezpublish_legacy.configuration_mapper')) {
            $container
                ->findDefinition('ezpublish_legacy.configuration_mapper')
                ->setClass(LegacyConfiguration::class);
        }
    }
}
