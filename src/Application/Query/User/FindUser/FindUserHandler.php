<?php

namespace App\Application\Query\User\FindUser;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

class FindUserHandler implements QueryHandlerInterface
{
    public function __invoke(FindUserQuery $query)
    {
        if ($query->userId) {
            return $this->userRepository->findOneByUuid($query->userId);
        }
        if ($query->email) {
            return $this->userRepository->findOneByEmail($query->email);
        }

        throw new \InvalidArgumentException();
    }

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
}
