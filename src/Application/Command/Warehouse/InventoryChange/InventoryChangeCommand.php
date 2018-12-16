<?php

namespace App\Application\Command\Warehouse\InventoryChange;

use App\Domain\Warehouse\Model\Product;

class InventoryChangeCommand
{
    /** @var Product */
    public $product;

    /** @var int */
    public $quantity;

    /**
     * InventoryChangeCommand constructor.
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }
}
