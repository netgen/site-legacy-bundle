<?php

declare(strict_types=1);

namespace Netgen\Bundle\MoreLegacyBundle;

use Netgen\Bundle\MoreLegacyBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NetgenMoreLegacyBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new Compiler\ImageVariationPass());
    }
}
