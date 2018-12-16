<?php

namespace App\Domain\Security\Exception;

/**
 * Class NullPasswordException.
 */
class NullPasswordException extends \InvalidArgumentException
{
    /**
     * NullPasswordException constructor.
     */
    public function __construct()
    {
        parent::__construct('security.exception.null_password', 006);
    }
}
