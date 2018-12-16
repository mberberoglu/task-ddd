<?php

namespace App\Domain\Warehouse\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;

class OrderItemId extends AggregateRootId
{
    /** @var string */
    protected $uuid;
}
