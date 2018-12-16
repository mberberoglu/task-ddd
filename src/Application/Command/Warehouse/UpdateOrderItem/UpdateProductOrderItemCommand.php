<?php

namespace App\Application\Command\Warehouse\UpdateOrderItem;

use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\Model\Product;

class UpdateProductOrderItemCommand
{
    /** @var Order */
    public $order;

    /** @var Product */
    public $product;

    /** @var int */
    public $quantity;

    /**
     * UpdateProductInOrderCommand constructor.
     */
    public function __construct(Order $order, Product $product, int $quantity)
    {
        $this->order = $order;
        $this->product = $product;
        $this->quantity = $quantity;
    }
}
