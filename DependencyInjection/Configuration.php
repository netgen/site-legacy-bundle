<?php

namespace Netgen\Bundle\MoreLegacyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends SiteAccessConfiguration
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root( 'netgen_more_legacy' );

        $rootNode
            ->children()
                ->arrayNode( 'enabled_legacy_settings' )
                    ->prototype( 'scalar' )
                    ->end()
                ->end()
            ->end();

        $this->generateScopeBaseNode( $rootNode )
            ->arrayNode( 'injected_settings' )
                ->prototype( 'array' )
                    ->requiresAtLeastOneElement()
                    ->normalizeKeys( false )
                        ->prototype( 'variable' )
                        ->end()
                ->end()
            ->end()
            ->arrayNode( 'injected_merge_settings' )
                ->prototype( 'array' )
                    ->requiresAtLeastOneElement()
                    ->normalizeKeys( false )
                        ->prototype( 'array' )
                            ->requiresAtLeastOneElement()
                            ->prototype( 'scalar' )
                            ->end()
                        ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
