<?php

namespace Netgen\Bundle\MoreLegacyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Netgen\Bundle\MoreLegacyBundle\DependencyInjection\Compiler;

class NetgenMoreLegacyBundle extends Bundle
{
    /**
     * Builds the bundle.
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new Compiler\ConfigurationMapperPass());
    }
}
