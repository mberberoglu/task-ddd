<?php

namespace App\Domain\Warehouse\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Warehouse\Model\OrderItem;
use App\Domain\Warehouse\ValueObject\OrderId;

final class OrderItemWasUpdated extends AbstractEvent
{
    /** @var OrderId */
    private $orderId;

    /** @var OrderId */
    private $productId;

    /** @var int */
    private $quantity;

    /** @var int */
    private $oldQuantity;

    /**
     * OrderItemWasUpdated constructor.
     *
     * @param $oldQuantity
     */
    public function __construct(OrderItem $orderItem, $oldQuantity)
    {
        parent::__construct();
        $this->orderId = $orderItem->uuid();
        $this->productId = $orderItem->product()->uuid();
        $this->quantity = $orderItem->quantity();
        $this->oldQuantity = $oldQuantity;
    }
}
