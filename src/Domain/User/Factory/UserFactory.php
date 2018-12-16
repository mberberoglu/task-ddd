<?php

namespace App\Domain\User\Factory;

use App\Domain\Security\ValueObject\EncodedPasswordInterface;
use App\Domain\User\Exception\EmailAlreadyExistException;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\UserId;

/**
 * Class UserFactory.
 */
class UserFactory implements UserFactoryInterface
{
    public function register(UserId $userId, Email $email, string $plainPassword): User
    {
        if ($this->userRepository->findOneByEmail($email)) {
            throw new EmailAlreadyExistException();
        }

        return User::create($userId, $email, $email, $this->encodedPassword::init($plainPassword));
    }

    public function __construct(UserRepositoryInterface $userRepository, EncodedPasswordInterface $encodedPassword)
    {
        $this->userRepository = $userRepository;
        $this->encodedPassword = $encodedPassword;
    }

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EncodedPasswordInterface
     */
    private $encodedPassword;
}
