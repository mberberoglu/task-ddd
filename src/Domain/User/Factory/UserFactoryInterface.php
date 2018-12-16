<?php

namespace App\Domain\User\Factory;

use App\Domain\User\Model\User;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\UserId;

/**
 * Interface UserFactoryInterface.
 */
interface UserFactoryInterface
{
    public function register(UserId $userId, Email $email, string $plainPassword): User;
}
