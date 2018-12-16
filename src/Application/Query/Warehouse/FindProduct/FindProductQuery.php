<?php

namespace App\Application\Query\Warehouse\FindProduct;

use App\Domain\Warehouse\ValueObject\ProductId;

class FindProductQuery
{
    /**
     * @var ProductId
     */
    public $productId;

    /**
     * GetProductQuery constructor.
     */
    public function __construct(ProductId $productId)
    {
        $this->productId = $productId;
    }
}
