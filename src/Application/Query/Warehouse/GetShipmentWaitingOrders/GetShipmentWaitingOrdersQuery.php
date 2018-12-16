<?php

namespace App\Application\Query\Warehouse\GetShipmentWaitingOrders;

class GetShipmentWaitingOrdersQuery
{
    /**
     * @var int
     */
    public $from;

    /**
     * @var int
     */
    public $limit;

    /**
     * GetShipmentWaitingOrdersQuery constructor.
     */
    public function __construct(int $from = 0, int $limit = 50)
    {
        $this->from = $from;
        $this->limit = $limit;
    }
}
