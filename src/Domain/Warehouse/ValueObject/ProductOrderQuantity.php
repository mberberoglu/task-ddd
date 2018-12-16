<?php

namespace App\Domain\Warehouse\ValueObject;

use App\Domain\Warehouse\Model\Product;

class ProductOrderQuantity
{
    /** @var Product */
    private $product;

    /** @var int */
    private $quantity;

    /**
     * ProductOrderQuantity constructor.
     */
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function decreaseQuantity(int $quantity): void
    {
        $this->quantity -= $quantity;
    }
}
