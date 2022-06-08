<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\DependencyInjection\Compiler;

use Ibexa\Bundle\Core\Imagine\VariationPathGenerator\OriginalDirectoryVariationPathGenerator;
use Ibexa\Bundle\Core\Imagine\VariationPurger\ImageFileVariationPurger;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ImageVariationPass implements CompilerPassInterface
{
    /**
     * Overrides built in Ibexa image variation purgers and path generators
     * to use ones specific for legacy.
     */
    public function process(ContainerBuilder $container): void
    {
        $container->setAlias(
            'ibexa.image_alias.variation_purger',
            ImageFileVariationPurger::class,
        );

        $container->setAlias(
            'ibexa.image_alias.variation_path_generator',
            OriginalDirectoryVariationPathGenerator::class,
        );
    }
}
