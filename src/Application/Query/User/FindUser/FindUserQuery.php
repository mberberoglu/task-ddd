<?php

namespace App\Application\Query\User\FindUser;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\UserId;

class FindUserQuery
{
    /**
     * @var UserId
     */
    public $userId;

    /**
     * @var Email
     */
    public $email;

    /**
     * FindUserQuery constructor.
     */
    private function __construct()
    {
    }

    public static function byUserId(UserId $userId): self
    {
        $query = new self();
        $query->userId = $userId;

        return $query;
    }

    public static function byEmail(Email $email): self
    {
        $query = new self();
        $query->email = $email;

        return $query;
    }
}
