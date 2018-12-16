<?php

namespace App\Application\Query\Company\FindCompany;

use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixInterface;

class FindCompanyQuery
{
    /**
     * @var CompanyId
     */
    public $companyId;

    /**
     * @var CompanyPrefixInterface
     */
    public $prefix;

    private function __construct()
    {
    }

    public static function byCompanyId(CompanyId $companyId): self
    {
        $query = new self();
        $query->companyId = $companyId;

        return $query;
    }

    public static function byPrefix(CompanyPrefixInterface $prefix): self
    {
        $query = new self();
        $query->prefix = $prefix;

        return $query;
    }
}
