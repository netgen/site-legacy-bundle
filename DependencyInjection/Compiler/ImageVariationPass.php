<?php

namespace Netgen\Bundle\MoreLegacyBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ImageVariationPass implements CompilerPassInterface
{
    /**
     * Overrides built in eZ Platform image variation purgers and path generators
     * to use ones specific for legacy.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $container->setAlias(
            'ezpublish.image_alias.variation_purger',
            'ezpublish.image_alias.variation_purger.legacy_storage_image_file'
        );

        $container->setAlias(
            'ezpublish.image_alias.variation_path_generator',
            'ezpublish.image_alias.variation_path_generator.original_directory'
        );
    }
}
