<?php

namespace App\Application\Command\Auth\Register;

use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\UserId;

class RegisterCommand
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
     * @var string
     */
    public $plainPassword;

    /**
     * RegisterCommand constructor.
     */
    public function __construct(UserId $userId, string $email, string $plainPassword)
    {
        $this->userId = $userId;
        $this->email = Email::fromString($email);
        $this->plainPassword = $plainPassword;
    }
}
