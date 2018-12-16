<?php

namespace App\Application\Query\Warehouse\GetOrder;

use App\Domain\Warehouse\ValueObject\OrderId;

class GetOrderQuery
{
    /**
     * @var OrderId
     */
    public $orderId;

    /**
     * GetOrderQuery constructor.
     */
    public function __construct(OrderId $orderId)
    {
        $this->orderId = $orderId;
    }
}
