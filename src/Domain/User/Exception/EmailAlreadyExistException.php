<?php

namespace App\Domain\User\Exception;

class EmailAlreadyExistException extends \InvalidArgumentException
{
    /**
     * EmailAlreadyExistException constructor.
     */
    public function __construct()
    {
        parent::__construct('user.exception.email_already_exists', 004);
    }
}
