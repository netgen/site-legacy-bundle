<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\Templating\Twig;

use eZ\Publish\Core\MVC\Legacy\Templating\Twig\Environment as BaseEnvironment;
use Netgen\Bundle\SiteBundle\Templating\Twig\DebugTemplate;
use Twig\Source;

use function sprintf;
use function str_replace;

final class Environment extends BaseEnvironment
{
    public function compileSource(Source $source): string
    {
        $compiledSource = parent::compileSource($source);

        if (!$this->isDebug()) {
            return $compiledSource;
        }

        return str_replace(
            ' extends Template',
            sprintf(' extends %s', DebugTemplate::class),
            $compiledSource,
        );
    }
}
