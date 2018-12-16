<?php

namespace App\Application\Command\Warehouse\CreateOrder;

use App\Domain\Company\Model\Company;
use App\Domain\User\Model\User;
use App\Domain\Warehouse\ValueObject\OrderId;
use App\Domain\Warehouse\ValueObject\ProductOrderQuantity;

class CreateOrderCommand
{
    /** @var OrderId */
    public $orderId;

    /** @var Company */
    public $company;

    /** @var User */
    public $user;

    /** @var Company */
    public $address;

    /** @var array|ProductOrderQuantity[] */
    public $productItems;

    /**
     * CreateOrderCommand constructor.
     *
     * @param array $productItems
     */
    public function __construct(OrderId $orderId, Company $company, User $user, string $address, $productItems = [])
    {
        $this->orderId = $orderId;
        $this->company = $company;
        $this->user = $user;
        $this->address = $address;
        $this->productItems = $productItems;
    }
}
