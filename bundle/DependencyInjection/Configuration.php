<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends SiteAccessConfiguration
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('netgen_site_legacy');

        $this->generateScopeBaseNode($rootNode)
            ->arrayNode('injected_settings')
                ->defaultValue([])
                ->prototype('array')
                    ->requiresAtLeastOneElement()
                    ->normalizeKeys(false)
                    ->prototype('variable')
                    ->end()
                ->end()
            ->end()
            ->arrayNode('injected_merge_settings')
                ->defaultValue([])
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
