<?php

namespace App\Infrastructure\Security\Security\AuthenticationProvider;

use App\Domain\Security\Auth\AuthenticationProviderInterface;
use App\Domain\User\Model\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthenticationProvider implements AuthenticationProviderInterface
{
    public function generateToken(User $user): string
    {
        return $this->jwtManager->create($user->auth());
    }

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    /**
     * @var JWTTokenManagerInterface
     */
    private $jwtManager;
}
