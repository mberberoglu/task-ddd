<?php

namespace App\Domain\Security\Exception;

/**
 * Class InvalidPasswordException.
 */
class InvalidPasswordException extends \InvalidArgumentException
{
    /**
     * InvalidPasswordException constructor.
     */
    public function __construct()
    {
        parent::__construct('security.exception.invalid_password', 005);
    }
}
