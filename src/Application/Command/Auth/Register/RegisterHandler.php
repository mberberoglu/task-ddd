<?php

namespace App\Application\Command\Auth\Register;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\User\Factory\UserFactoryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

/**
 * Class LoginHandler.
 */
class RegisterHandler implements CommandHandlerInterface
{
    public function __invoke(RegisterCommand $command): void
    {
        $user = $this->userFactory->register($command->userId, $command->email, $command->plainPassword);

        $this->userRepository->save($user);
    }

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var UserFactoryInterface
     */
    private $userFactory;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserFactoryInterface $userFactory
    ) {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }
}
