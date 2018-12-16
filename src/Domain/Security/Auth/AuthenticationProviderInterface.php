<?php

namespace App\Domain\Security\Auth;

use App\Domain\User\Model\User;

interface AuthenticationProviderInterface
{
    public function generateToken(User $user): string;
}
