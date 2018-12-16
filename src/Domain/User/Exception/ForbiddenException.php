<?php

namespace App\Domain\User\Exception;

class ForbiddenException extends \RuntimeException
{
    /**
     * ForbiddenException constructor.
     */
    public function __construct()
    {
        parent::__construct('user.exception.forbidden', 2004);
    }
}
