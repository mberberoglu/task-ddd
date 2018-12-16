<?php

namespace App\Domain\Warehouse\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Warehouse\ValueObject\OrderId;

final class OrderAddressWasUpdated extends AbstractEvent
{
    /** @var OrderId */
    private $orderId;

    /** @var string */
    private $address;

    /** @var string */
    private $oldAddress;

    /**
     * OrderAddressWasUpdated constructor.
     */
    public function __construct(OrderId $orderId, string $address, string $oldAddress)
    {
        $this->orderId = $orderId;
        $this->address = $address;
        $this->oldAddress = $oldAddress;
    }
}
