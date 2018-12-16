<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\UserId;

/**
 * Interface UserRepositoryInterface.
 */
interface UserRepositoryInterface
{
    public function getOneByUuid(UserId $userId): User;

    public function findOneByUuid(UserId $userId): ?User;

    public function findOneByUsername(string $username): ?User;

    public function findOneByEmail(Email $email): ?User;

    public function save(User $user): void;
}
