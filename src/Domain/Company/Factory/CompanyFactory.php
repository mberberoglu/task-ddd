<?php

namespace App\Domain\Company\Factory;

use App\Domain\Company\Exception\PrefixAlreadyUsingException;
use App\Domain\Company\Model\Company;
use App\Domain\Company\Repository\CompanyRepositoryInterface;
use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixFactory;
use App\Domain\User\Model\User;

/**
 * Class CompanyFactory.
 */
class CompanyFactory implements CompanyFactoryInterface
{
    public function establish(CompanyId $uuid, User $user, string $name, string $type, string $prefix): Company
    {
        if ($this->companyRepository->findOneByPrefix(CompanyPrefixFactory::make($type)::fromString($prefix))) {
            throw new PrefixAlreadyUsingException();
        }

        return Company::create($uuid, $user, $name, $type, $prefix);
    }

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
}
