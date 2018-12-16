<?php

namespace App\Infrastructure\Security\ValueObject;

use App\Domain\Security\Exception\InvalidPasswordException;
use App\Domain\Security\Exception\NullPasswordException;
use App\Domain\Security\ValueObject\EncodedPasswordInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

/**
 * Class EncodedPassword.
 */
final class EncodedPassword implements EncodedPasswordInterface
{
    const
        COST = 12
    ;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var BCryptPasswordEncoder
     */
    private $encoder;

    public static function init(?string $plainPassword = null): EncodedPasswordInterface
    {
        $encodedPassword = new self();
        if (null === $plainPassword) {
            throw new NullPasswordException();
        }

        $encodedPassword->encoder = new BCryptPasswordEncoder(static::COST);

        $encodedPassword->validate($plainPassword);

        $encodedPassword->setPassword($plainPassword);

        return $encodedPassword;
    }

    private function setPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;

        $this->password = $this->encoder->encodePassword($plainPassword, null);
    }

    public function matchHash(string $encodedPassword): bool
    {
        return password_verify($this->plainPassword, $encodedPassword);
    }

    /**
     * @throws InvalidPasswordException
     */
    private function validate(?string $plainPassword): void
    {
        if (8 > \strlen($plainPassword)) {
            throw new InvalidPasswordException();
        }
    }

    public function __toString(): string
    {
        return $this->password;
    }
}
