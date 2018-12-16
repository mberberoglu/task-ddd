<?php

namespace App\Domain\Warehouse\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Company\Model\Company;
use App\Domain\Warehouse\Model\Product;
use App\Domain\Warehouse\ValueObject\ProductId;

final class ProductWasCreated extends AbstractEvent
{
    /** @var ProductId */
    private $productId;

    /** @var Company */
    private $company;

    /** @var string */
    private $name;

    /**
     * ProductWasCreated constructor.
     */
    public function __construct(Product $product)
    {
        parent::__construct();
        $this->productId = $product->uuid();
        $this->company = $product->company();
        $this->name = $product->name();
    }

    public function productId(): ProductId
    {
        return $this->productId;
    }

    public function company(): Company
    {
        return $this->company;
    }

    public function name(): string
    {
        return $this->name;
    }
}
