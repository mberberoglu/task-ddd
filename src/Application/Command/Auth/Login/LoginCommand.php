<?php

namespace App\Application\Command\Auth\Login;

use App\Domain\User\ValueObject\Email;

class LoginCommand
{
    /**
     * @var Email
     */
    public $email;

    /**
     * @var string
     */
    public $plainPassword;

    /**
     * LoginCommand constructor.
     */
    public function __construct(string $email, string $plainPassword)
    {
        $this->email = Email::fromString($email);
        $this->plainPassword = $plainPassword;
    }
}
