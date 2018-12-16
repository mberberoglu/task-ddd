<?php

namespace App\Domain\Warehouse\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\ValueObject\OrderId;

final class OrderWasCancelled extends AbstractEvent
{
    /** @var OrderId */
    private $orderId;

    /**
     * OrderWasCancelled constructor.
     */
    public function __construct(Order $order)
    {
        parent::__construct();
        $this->orderId = $order->uuid();
    }
}
