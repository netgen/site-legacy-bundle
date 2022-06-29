<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\DependencyInjection\Compiler;

use Ibexa\Contracts\Core\Persistence\Handler;
use Ibexa\Contracts\Core\Search\VersatileHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Makes the services required by ngsymfonytools legacy extension public
 */
class PublicServicesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->has('router')) {
            $container->findDefinition('router')
                ->setPublic(true);
        }

        if ($container->has('fragment.handler')) {
            $container->findDefinition('fragment.handler')
                ->setPublic(true);
        }

        if ($container->has('security.authorization_checker')) {
            $container->findDefinition('security.authorization_checker')
                ->setPublic(true);
        }

        if ($container->has('ibexa.api.repository')) {
            $container->findDefinition('ibexa.api.repository')
                ->setPublic(true);
        }

        if ($container->has(Handler::class)) {
            $container->findDefinition(Handler::class)
                ->setPublic(true);
        }
    }
}
