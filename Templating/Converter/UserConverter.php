<?php

namespace Netgen\Bundle\MoreLegacyBundle\Templating\Converter;

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

    /**
     * Constructor.
     *
     * @param \Closure $legacyKernel
     */
    public function __construct(Closure $legacyKernel)
    {
        $this->legacyKernel = $legacyKernel;
    }

    /**
     * Converts $object to make it compatible with legacy eZTemplate API.
     *
     * @param \eZ\Publish\API\Repository\Values\User\User $object
     *
     * @throws \InvalidArgumentException If $object is actually not an object
     *
     * @return \eZUser
     */
    public function convert($object)
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
