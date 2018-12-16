<?php

namespace App\Domain\Warehouse\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Warehouse\Model\OrderItem;
use App\Domain\Warehouse\ValueObject\OrderId;

final class OrderItemWasCreated extends AbstractEvent
{
    /** @var OrderId */
    private $orderId;

    /** @var OrderId */
    private $productId;

    /** @var int */
    private $quantity;

    /**
     * OrderItemWasCreated constructor.
     */
    public function __construct(OrderItem $orderItem)
    {
        parent::__construct();
        $this->orderId = $orderItem->uuid();
        $this->productId = $orderItem->uuid();
        $this->quantity = $orderItem->quantity();
    }
}
