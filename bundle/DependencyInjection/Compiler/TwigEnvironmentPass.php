<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\DependencyInjection\Compiler;

use Netgen\Bundle\SiteLegacyBundle\Templating\Twig\Environment;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class TwigEnvironmentPass implements CompilerPassInterface
{
    /**
     * Overrides the Ibexa legacy Twig environment to add path to template to rendered markup.
     */
    public function process(ContainerBuilder $container): void
    {
        if ($container->has('twig')) {
            $container
                ->findDefinition('twig')
                ->setClass(Environment::class);
        }
    }
}
