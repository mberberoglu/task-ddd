<?php

namespace App\Domain\Warehouse\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Company\Model\Company;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\ValueObject\OrderId;

final class OrderWasCreated extends AbstractEvent
{
    /** @var OrderId */
    private $orderId;

    /** @var Company */
    private $company;

    /**
     * OrderWasCreated constructor.
     */
    public function __construct(Order $order)
    {
        parent::__construct();
        $this->orderId = $order->uuid();
        $this->company = $order->company();
    }

    public function orderId(): OrderId
    {
        return $this->orderId;
    }

    public function company(): Company
    {
        return $this->company;
    }
}
