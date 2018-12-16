<?php

namespace App\Application\Command\User\AssignCompany;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Company\Repository\CompanyRepositoryInterface;
use App\Domain\User\Repository\UserRepositoryInterface;

/**
 * Class EstablishHandler.
 */
class AssignCompanyHandler implements CommandHandlerInterface
{
    public function __invoke(AssignCompanyCommand $command): void
    {
        $user = $this->userRepository->getOneByUuid($command->userId);
        $company = $this->companyRepository->getOneByUuid($command->companyId);

        $user->assignCompany($company);
        $this->userRepository->save($user);
    }

    public function __construct(
        UserRepositoryInterface $userRepository,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
}
