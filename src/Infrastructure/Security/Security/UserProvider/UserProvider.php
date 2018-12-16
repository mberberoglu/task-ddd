<?php

namespace App\Infrastructure\Security\Security\UserProvider;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Security\Security\Model\Auth;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserProvider.
 */
class UserProvider implements UserProviderInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @throws UsernameNotFoundException if the user is not found
     *
     * @return UserInterface
     */
    public function loadUserByUsername($username)
    {
        $user = $this->repository->findOneByUsername($username);

        if (!$user) {
            throw new UsernameNotFoundException();
        }

        return new Auth($user->uuid()->toString(), $user->auth(), $user->company());
    }

    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     *
     * @throws UnsupportedUserException if the account is not supported
     *
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return Auth::class === $class;
    }
}
