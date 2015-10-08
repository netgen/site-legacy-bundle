<?php

namespace Netgen\Bundle\MoreLegacyBundle\Core\MVC\Legacy\View\Provider;

use eZ\Publish\Core\MVC\Legacy\View\Provider\Content as BaseContent;
use eZ\Publish\Core\MVC\Symfony\View\Provider\Location as LocationViewProvider;
use eZ\Publish\API\Repository\Values\Content\ContentInfo;
use eZ\Publish\API\Repository\Values\Content\Location;

class Content extends BaseContent
{
    /**
     * @var \eZ\Publish\Core\MVC\Symfony\View\Provider\Location
     */
    protected $locationViewProvider;

    /**
     * Sets the location view provider
     *
     * @param \eZ\Publish\Core\MVC\Symfony\View\Provider\Location $locationViewProvider
     */
    public function setLocationViewProvider( LocationViewProvider $locationViewProvider )
    {
        $this->locationViewProvider = $locationViewProvider;
    }

    /**
     * Returns a ContentView object corresponding to $contentInfo, or void if not applicable.
     *
     * @param \eZ\Publish\API\Repository\Values\Content\ContentInfo $contentInfo
     * @param string $viewType Variation of display for your content
     * @param array $parameters
     *
     * @return \eZ\Publish\Core\MVC\Symfony\View\ContentView|void
     */
    public function getView( ContentInfo $contentInfo, $viewType, $parameters = array() )
    {
        if ( isset( $parameters['location'] ) && $parameters['location'] instanceof Location )
        {
            return $this->locationViewProvider->getView( $parameters['location'], $viewType );
        }

        return parent::getView( $contentInfo, $viewType );
    }
}
