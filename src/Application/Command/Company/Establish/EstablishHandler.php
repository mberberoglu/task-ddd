<?php

namespace App\Application\Command\Company\Establish;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Company\Factory\CompanyFactoryInterface;
use App\Domain\Company\Repository\CompanyRepositoryInterface;

/**
 * Class EstablishHandler.
 */
class EstablishHandler implements CommandHandlerInterface
{
    public function __invoke(EstablishCommand $command): void
    {
        $company = $this->companyFactory->establish($command->uuid, $command->user, $command->name, $command->type, $command->prefix);

        $this->companyRepository->save($company);
    }

    public function __construct(
        CompanyFactoryInterface $companyFactory,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->companyFactory = $companyFactory;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @var CompanyFactoryInterface
     */
    private $companyFactory;

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
}
