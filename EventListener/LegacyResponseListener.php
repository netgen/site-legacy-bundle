<?php

namespace Netgen\Bundle\MoreLegacyBundle\EventListener;

use Netgen\Bundle\MoreLegacyBundle\Exception\NotFoundHttpException;
use eZ\Bundle\EzPublishLegacyBundle\LegacyResponse;
use eZ\Bundle\EzPublishLegacyBundle\Routing\FallbackRouter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LegacyResponseListener implements EventSubscriberInterface
{
    /**
     * @var bool
     */
    protected $legacyMode;

    /**
     * Constructor.
     *
     * @param bool $legacyMode
     */
    public function __construct($legacyMode)
    {
        $this->legacyMode = $legacyMode;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(KernelEvents::RESPONSE => array('onKernelResponse', 10));
    }

    /**
     * Converts the legacy 404 response to proper Symfony exception.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $routeName = $event->getRequest()->attributes->get('_route');
        if ($routeName !== FallbackRouter::ROUTE_NAME) {
            return;
        }

        $response = $event->getResponse();
        if (!$response instanceof LegacyResponse) {
            return;
        }

        if (!$this->legacyMode && $response->getStatusCode() == Response::HTTP_NOT_FOUND) {
            $moduleResult = $response->getModuleResult();
            $exception = new NotFoundHttpException(
                isset($moduleResult['errorMessage']) ?
                    $moduleResult['errorMessage'] :
                    'Not Found'
            );

            $exception->setOriginalResponse($response);

            throw $exception;
        }
    }
}
