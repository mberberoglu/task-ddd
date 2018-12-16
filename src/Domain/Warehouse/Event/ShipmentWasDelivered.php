<?php

namespace App\Domain\Warehouse\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Warehouse\Model\Shipment;
use App\Domain\Warehouse\ValueObject\OrderId;
use App\Domain\Warehouse\ValueObject\ShipmentId;

final class ShipmentWasDelivered extends AbstractEvent
{
    /** @var ShipmentId */
    private $shipmentId;

    /** @var OrderId */
    private $orderId;

    /** @var string */
    private $type;

    /**
     * ShipmentWasCreated constructor.
     */
    public function __construct(Shipment $shipment)
    {
        parent::__construct();
        $this->shipmentId = $shipment->uuid();
        $this->orderId = $shipment->order()->uuid();
        $this->type = $shipment->type();
    }
}
