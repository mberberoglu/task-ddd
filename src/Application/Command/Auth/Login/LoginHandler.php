<?php

namespace App\Application\Command\Auth\Login;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Security\Exception\AuthenticationException;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class LoginHandler.
 */
class LoginHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    public function __construct(
        UserRepositoryInterface $userRepository,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->userRepository = $userRepository;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @throws AuthenticationException
     */
    public function __invoke(LoginCommand $command): void
    {
        /** @var User $user */
        $user = $this->userRepository->findOneByUsername($command->email);

        if (!$user) {
            throw new AuthenticationException();
        }
    }
}
