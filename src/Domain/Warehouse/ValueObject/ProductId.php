<?php

namespace App\Domain\Warehouse\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;

class ProductId extends AggregateRootId
{
    /** @var string */
    protected $uuid;
}
