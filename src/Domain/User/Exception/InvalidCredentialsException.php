<?php

namespace App\Domain\User\Exception;

class InvalidCredentialsException extends \RuntimeException
{
    /**
     * UserNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('user.exception.invalid_credentials', 004);
    }
}
