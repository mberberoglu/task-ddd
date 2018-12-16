<?php

namespace App\Domain\Warehouse\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;

class ShipmentId extends AggregateRootId
{
    /** @var string */
    protected $uuid;

    public function getShipmentNumber()
    {
        return strtoupper(substr($this->uuid, -9));
    }
}
