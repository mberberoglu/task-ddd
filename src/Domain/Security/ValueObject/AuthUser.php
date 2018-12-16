<?php

namespace App\Domain\Security\ValueObject;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AuthUser.
 */
final class AuthUser implements UserInterface
{
    const DEFAULT_ROLES = [
        'ROLE_USER',
    ];

    /**
     * @var string
     */
    private $username;

    /**
     * @var string|null
     */
    private $companyId;

    /**
     * @var string
     */
    private $passwordHash;

    /**
     * @var array
     */
    private $roles = [];

    public function __construct(string $username, EncodedPasswordInterface $encodedPassword, array $roles = [])
    {
        $this->username = $username;
        $this->passwordHash = (string) $encodedPassword;
        $this->roles = array_merge(self::DEFAULT_ROLES, $roles);
    }

    public function username(): string
    {
        return $this->username;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function password(): string
    {
        return $this->passwordHash;
    }

    public function roles(): array
    {
        return $this->roles;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    public function setCompanyId(?string $companyId): void
    {
        $this->companyId = $companyId;
    }
}
