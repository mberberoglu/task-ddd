<?php

namespace App\Application\Query\Auth\GetToken;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Security\Auth\AuthenticationProviderInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class GetTokenHandler implements QueryHandlerInterface
{
    public function __invoke(GetTokenQuery $query)
    {
        $user = $this->userRepository->findOneByEmail($query->email);

        return $this->authenticationProvider->generateToken($user);
    }

    public function __construct(
        UserRepositoryInterface $userRepository,
        AuthenticationProviderInterface $authenticationProvider
    ) {
        $this->userRepository = $userRepository;
        $this->authenticationProvider = $authenticationProvider;
    }

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $authenticationProvider;
}
