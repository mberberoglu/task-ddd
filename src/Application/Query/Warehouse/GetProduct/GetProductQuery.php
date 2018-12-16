<?php

namespace App\Application\Query\Warehouse\GetProduct;

use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Warehouse\ValueObject\ProductId;

class GetProductQuery
{
    /**
     * @var ProductId
     */
    public $productId;

    /**
     * @var CompanyId
     */
    public $companyId;

    /**
     * GetProductQuery constructor.
     */
    public function __construct(ProductId $productId, ?CompanyId $companyId = null)
    {
        $this->productId = $productId;
        $this->companyId = $companyId;
    }
}
