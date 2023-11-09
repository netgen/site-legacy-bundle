<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\Core\FieldType\XmlText\Converter;

use DOMDocument;
use eZ\Publish\Core\FieldType\XmlText\Converter\EmbedToHtml5 as BaseEmbedToHtml5;
use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException as APINotFoundException;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo as APIVersionInfo;
use Ibexa\Core\Base\Exceptions\UnauthorizedException;
use Netgen\IbexaSiteApi\API\Values\Content;
use Netgen\IbexaSiteApi\API\Values\Location;
use Netgen\IbexaSiteApi\Core\Traits\SiteAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\HttpKernel\Controller\ControllerReference;

use function sprintf;

/**
 * Converts embedded elements from internal XmlText representation to HTML5.
 *
 * Overrides the built in converter to allow rendering embedded content with Site API controller.
 */
class EmbedToHtml5 extends BaseEmbedToHtml5
{
    use SiteAwareTrait;

    protected function processTag(DOMDocument $xmlDoc, $tagName): void
    {
        $this->logger = $this->logger ?? new NullLogger();
        $permissionResolver = $this->repository->getPermissionResolver();

        /** @var \DOMElement $embed */
        foreach ($xmlDoc->getElementsByTagName($tagName) as $embed) {
            if (!$view = $embed->getAttribute('view')) {
                $view = $tagName;
            }

            $embedContent = null;
            $parameters = $this->getParameters($embed);

            $contentId = $embed->getAttribute('object_id');
            $locationId = $embed->getAttribute('node_id');

            if ($contentId) {
                try {
                    /** @var \Netgen\IbexaSiteApi\API\Values\Content $content */
                    $content = $this->repository->sudo(
                        fn (Repository $repository): Content => $this->site->getLoadService()->loadContent((int) $contentId),
                    );

                    if (
                        !$permissionResolver->canUser('content', 'read', $content->innerContent)
                        && !$permissionResolver->canUser('content', 'view_embed', $content->innerContent)
                    ) {
                        throw new UnauthorizedException('content', 'read', ['contentId' => $contentId]);
                    }

                    // Check published status of the Content
                    if (
                        $content->versionInfo->status !== APIVersionInfo::STATUS_PUBLISHED
                        && !$permissionResolver->canUser('content', 'versionread', $content->innerContent)
                    ) {
                        throw new UnauthorizedException('content', 'versionread', ['contentId' => $contentId]);
                    }

                    $embedContent = $this->fragmentHandler->render(
                        new ControllerReference(
                            'ng_content:embedAction',
                            [
                                'content' => $content,
                                'viewType' => $view,
                                'layout' => false,
                                'params' => $parameters,
                            ],
                        ),
                    );
                } catch (APINotFoundException $e) {
                    $this->logger->error(
                        sprintf('While generating embed for xmltext, could not locate content with ID %d', $contentId),
                    );
                }
            } elseif ($locationId) {
                try {
                    /** @var \Netgen\IbexaSiteApi\API\Values\Location $location */
                    $location = $this->repository->sudo(
                        fn (Repository $repository): Location => $this->site->getLoadService()->loadLocation((int) $locationId),
                    );

                    if (
                        !$permissionResolver->canUser('content', 'read', $location->contentInfo->innerContentInfo, [$location->innerLocation])
                        && !$permissionResolver->canUser('content', 'view_embed', $location->contentInfo->innerContentInfo, [$location->innerLocation])
                    ) {
                        throw new UnauthorizedException('content', 'read', ['locationId' => $location->id]);
                    }

                    $embedContent = $this->fragmentHandler->render(
                        new ControllerReference(
                            'ng_content:embedAction',
                            [
                                'content' => $location->content,
                                'location' => $location,
                                'viewType' => $view,
                                'layout' => false,
                                'params' => $parameters,
                            ],
                        ),
                    );
                } catch (APINotFoundException $e) {
                    $this->logger->error(
                        sprintf('While generating embed for xmltext, could not locate location with ID %d', $locationId),
                    );
                }
            }

            if ($embedContent === null) {
                // Remove empty embed
                $embed->parentNode->removeChild($embed);
            } else {
                $embed->appendChild($xmlDoc->createCDATASection($embedContent));
            }
        }
    }
}