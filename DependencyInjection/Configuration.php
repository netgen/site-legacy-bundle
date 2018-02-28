<?php

declare(strict_types=1);

namespace Netgen\Bundle\MoreLegacyBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends SiteAccessConfiguration
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('netgen_more_legacy');

        $rootNode
            ->children()
                ->arrayNode('enabled_legacy_settings')
                    ->defaultValue(array())
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end();

        $this->generateScopeBaseNode($rootNode)
            ->arrayNode('injected_settings')
                ->defaultValue(array())
                ->prototype('array')
                    ->requiresAtLeastOneElement()
                    ->normalizeKeys(false)
                    ->prototype('variable')
                    ->end()
                ->end()
            ->end()
            ->arrayNode('injected_merge_settings')
                ->defaultValue(array())
                ->prototype('array')
                    ->requiresAtLeastOneElement()
                    ->normalizeKeys(false)
                    ->prototype('array')
                        ->requiresAtLeastOneElement()
                        ->prototype('scalar')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
