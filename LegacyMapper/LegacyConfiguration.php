<?php

namespace Netgen\Bundle\MoreLegacyBundle\LegacyMapper;

use eZ\Bundle\EzPublishLegacyBundle\LegacyMapper\Configuration;
use eZ\Publish\Core\MVC\Legacy\Event\PreBuildKernelEvent;
use RuntimeException;

class LegacyConfiguration extends Configuration
{
    /**
     * Adds settings to the parameters that will be injected into the legacy kernel
     *
     * Overriden because this crashes if database does not exist yet or is not initialized
     *
     * @param \eZ\Publish\Core\MVC\Legacy\Event\PreBuildKernelEvent $event
     */
    public function onBuildKernel( PreBuildKernelEvent $event )
    {
        try
        {
            parent::onBuildKernel( $event );
        }
        catch ( RuntimeException $e )
        {
            // Do nothing
        }
    }
}
