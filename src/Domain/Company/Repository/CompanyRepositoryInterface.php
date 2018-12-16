<?php

namespace App\Domain\Company\Repository;

use App\Domain\Company\Model\Company;
use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixInterface;

/**
 * Interface CompanyRepositoryInterface.
 */
interface CompanyRepositoryInterface
{
    public function getOneByUuid(CompanyId $companyId): Company;

    public function findOneByUuid(CompanyId $companyId): ?Company;

    public function getOneByPrefix(CompanyPrefixInterface $prefix): Company;

    public function findOneByPrefix(CompanyPrefixInterface $prefix): ?Company;

    public function save(Company $company): void;
}
