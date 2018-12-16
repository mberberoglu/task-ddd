<?php

namespace App\Domain\Warehouse\Repository;

use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\ValueObject\OrderId;

interface OrderRepositoryInterface
{
    public function getOneByUuid(OrderId $orderId): Order;

    public function findOneByUuid(OrderId $orderId): ?Order;

    public function getOneByOrderNumber(string $orderNumber): Order;

    public function findOneByOrderNumber(string $orderNumber): ?Order;

    public function findAllShipmentWaiting(int $from = 0, int $limit = 50);

    public function countAllShipmentWaiting(): int;

    public function save(Order $order): void;
}
