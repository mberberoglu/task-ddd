<?php

namespace App\Application\Query\Warehouse\GetProductsByCompany;

use App\Domain\Company\ValueObject\CompanyId;

class GetProductsByCompanyQuery
{
    /**
     * @var CompanyId
     */
    public $uuid;

    /**
     * @var int
     */
    public $from;
    /**
     * @var int
     */
    public $limit;

    /**
     * GetProductsByCompanyQuery constructor.
     */
    public function __construct(CompanyId $uuid, int $from = 0, int $limit = 50)
    {
        $this->uuid = $uuid;
        $this->from = $from;
        $this->limit = $limit;
    }
}
