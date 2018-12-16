<?php

namespace App\Application\Command\Warehouse\UpdateOrderAddress;

use App\Domain\Warehouse\Model\Order;

class UpdateOrderAddressCommand
{
    /** @var Order */
    public $order;

    /** @var string */
    public $address;

    /**
     * UpdateOrderAddressCommand constructor.
     */
    public function __construct(Order $order, string $address)
    {
        $this->order = $order;
        $this->address = $address;
    }
}
