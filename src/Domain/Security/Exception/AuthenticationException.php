<?php

namespace App\Domain\Security\Exception;

/**
 * Class AuthenticationException.
 */
class AuthenticationException extends \Exception
{
    /**
     * AuthenticationException constructor.
     */
    public function __construct()
    {
        parent::__construct('security.exception.authentication_exception');
    }
}
