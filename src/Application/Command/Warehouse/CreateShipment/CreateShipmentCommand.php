<?php

namespace App\Application\Command\Warehouse\CreateShipment;

use App\Domain\Company\Model\Company;
use App\Domain\User\Model\User;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\ValueObject\ShipmentId;

class CreateShipmentCommand
{
    /** @var ShipmentId */
    public $shipmentId;

    /** @var Order */
    public $order;

    /** @var Company */
    public $company;

    /** @var User */
    public $user;

    /** @var string */
    public $type;

    /**
     * CreateShipmentCommand constructor.
     */
    public function __construct(Order $order, Company $company, User $user, string $type)
    {
        $this->shipmentId = new ShipmentId();
        $this->order = $order;
        $this->company = $company;
        $this->user = $user;
        $this->type = $type;
    }
}
