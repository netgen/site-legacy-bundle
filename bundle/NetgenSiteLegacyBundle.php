<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle;

use Netgen\Bundle\SiteLegacyBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NetgenSiteLegacyBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new Compiler\ImageVariationPass());
    }
}
