<?php

declare(strict_types=1);

namespace Netgen\Bundle\SiteLegacyBundle\Templating\Converter;

use Closure;
use eZ\Publish\API\Repository\Values\User\User;
use eZ\Publish\Core\MVC\Legacy\Templating\Converter\ObjectConverter;
use eZUser;
use InvalidArgumentException;

class UserConverter implements ObjectConverter
{
    /**
     * @var \Closure
     */
    protected $legacyKernel;

    public function __construct(Closure $legacyKernel)
    {
        $this->legacyKernel = $legacyKernel;
    }

    public function convert($object): eZUser
    {
        if (!$object instanceof User) {
            throw new InvalidArgumentException('$object is not a User instance');
        }

        $legacyKernel = $this->legacyKernel;

        return $legacyKernel()->runCallback(
            function () use ($object) {
                return eZUser::fetchByName($object->login);
            },
            false,
            false
        );
    }
}
