<?php

namespace App\Domain\Warehouse\Model;

use App\Domain\Common\ValueObject\AggregateRoot;
use App\Domain\Warehouse\Event\OrderItemWasCreated;
use App\Domain\Warehouse\ValueObject\OrderItemId;
use App\Domain\Warehouse\ValueObject\ProductOrderQuantity;

class OrderItem extends AggregateRoot
{
    /** @var OrderItemId */
    protected $uuid;

    /** @var Order */
    protected $order;

    /** @var Product */
    private $product;

    /** @var int */
    private $quantity;

    /**
     * OrderItem constructor.
     */
    protected function __construct(Order $order, ProductOrderQuantity $item)
    {
        parent::__construct(new OrderItemId());
        $this->order = $order;
        $this->product = $item->product();
        $this->quantity = $item->quantity();
    }

    /**
     * @throws \Exception
     *
     * @return Order
     */
    public static function create(Order $order, ProductOrderQuantity $item): self
    {
        $order = new self($order, $item);

        $order->raise(new OrderItemWasCreated($order));

        return $order;
    }

    public function product(): Product
    {
        return $this->product;
    }

    public function item(): ProductOrderQuantity
    {
        return new ProductOrderQuantity($this->product(), $this->quantity());
    }

    public function quantity(): int
    {
        return $this->quantity;
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
