<?php

namespace App\Domain\Warehouse\Repository;

use App\Domain\Warehouse\Model\OrderItem;

interface OrderItemRepositoryInterface
{
    public function remove(OrderItem $orderItem): void;
}
