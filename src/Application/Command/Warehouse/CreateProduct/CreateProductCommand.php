<?php

namespace App\Application\Command\Warehouse\CreateProduct;

use App\Domain\Company\Model\Company;
use App\Domain\Warehouse\ValueObject\ProductId;

class CreateProductCommand
{
    /** @var ProductId */
    public $productId;

    /** @var Company */
    public $company;

    /** @var string */
    public $name;

    /**
     * CreateProductCommand constructor.
     *
     * @throws \Exception
     */
    public function __construct(ProductId $productId, Company $company, string $name)
    {
        $this->productId = $productId;
        $this->company = $company;
        $this->name = $name;
    }
}
