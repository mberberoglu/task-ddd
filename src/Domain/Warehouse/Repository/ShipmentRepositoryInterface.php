<?php

namespace App\Domain\Warehouse\Repository;

use App\Domain\Warehouse\Model\Shipment;
use App\Domain\Warehouse\ValueObject\ShipmentId;

interface ShipmentRepositoryInterface
{
    public function getOneByUuid(ShipmentId $userId): Shipment;

    public function findOneByUuid(ShipmentId $userId): ?Shipment;

    public function getOneByShipmentNumber(string $shipmentNumber): Shipment;

    public function findOneByShipmentNumber(string $shipmentNumber): ?Shipment;

    public function save(Shipment $shipment): void;
}
