<?php

namespace App\Domain\User\ValueObject;

use Assert\Assertion;

class Email
{
    /** @var string */
    private $email;

    private function __construct()
    {
    }

    /**
     * @return Email
     */
    public static function fromString(string $email): self
    {
        Assertion::email($email, 'Not a valid email');

        $mail = new self();

        $mail->email = $email;

        return $mail;
    }

    public function toString(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
