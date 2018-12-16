<?php

namespace App\Domain\Warehouse\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Warehouse\ValueObject\ProductId;

final class ProductInventoryChanged extends AbstractEvent
{
    /** @var ProductId */
    private $productId;

    /** @var int */
    private $quantity;

    /**
     * ProductInventoryChanged constructor.
     */
    public function __construct(ProductId $productId, int $quantity)
    {
        parent::__construct();
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function productId(): ProductId
    {
        return $this->productId;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }
}
