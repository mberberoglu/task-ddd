<?php

namespace App\Application\Query\Company\FindCompany;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Company\Repository\CompanyRepositoryInterface;

class FindCompanyHandler implements QueryHandlerInterface
{
    public function __invoke(FindCompanyQuery $query)
    {
        if ($query->companyId) {
            return $this->companyRepository->findOneByUuid($query->companyId);
        }
        if ($query->prefix) {
            return $this->companyRepository->findOneByPrefix($query->prefix->toString());
        }

        throw new \InvalidArgumentException();
    }

    public function __construct(
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
}
