<?php

namespace App\Domain\Warehouse\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;

class OrderId extends AggregateRootId
{
    /** @var string */
    protected $uuid;

    public function getOrderNumber()
    {
        return strtoupper(substr($this->uuid, -9));
    }
}
