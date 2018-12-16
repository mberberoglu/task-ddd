<?php

namespace App\Application\Command\Warehouse\DeliverShipment;

use App\Domain\Warehouse\ValueObject\OrderId;

class DeliverShipmentCommand
{
    /** @var OrderId */
    public $orderId;

    /**
     * DeliverShipmentCommand constructor.
     */
    public function __construct(OrderId $orderId)
    {
        $this->orderId = $orderId;
    }
}
