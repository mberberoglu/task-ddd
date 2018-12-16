<?php

namespace App\Infrastructure\Company\Repository;

use App\Domain\Company\Exception\CompanyNotFoundException;
use App\Domain\Company\Model\Company;
use App\Domain\Company\Repository\CompanyRepositoryInterface;
use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class CompanyRepository.
 */
class CompanyRepository extends ServiceEntityRepository implements CompanyRepositoryInterface
{
    public function findOneByUuid(CompanyId $companyId): ?Company
    {
        return $this->createQueryBuilder('company')
            ->where('company.uuid = :id')
            ->setParameter('id', $companyId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByPrefix(CompanyPrefixInterface $prefix): ?Company
    {
        return $this->createQueryBuilder('company')
            ->where('company.prefix = :prefix')
            ->setParameter('prefix', $prefix)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getOneByUuid(CompanyId $companyId): Company
    {
        $company = $this->findOneByUuid($companyId);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        return $company;
    }

    public function getOneByPrefix(CompanyPrefixInterface $prefix): Company
    {
        $company = $this->findOneByPrefix($prefix);

        if (!$company) {
            throw new CompanyNotFoundException();
        }

        return $company;
    }

    public function save(Company $company): void
    {
        $this->_em->persist($company);
        $this->_em->flush();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }
}
