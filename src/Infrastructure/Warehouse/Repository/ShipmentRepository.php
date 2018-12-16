<?php

namespace App\Infrastructure\Warehouse\Repository;

use App\Domain\Warehouse\Exception\ShipmentNotFoundException;
use App\Domain\Warehouse\Model\Shipment;
use App\Domain\Warehouse\Repository\ShipmentRepositoryInterface;
use App\Domain\Warehouse\ValueObject\ShipmentId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class ShipmentRepository.
 */
class ShipmentRepository extends ServiceEntityRepository implements ShipmentRepositoryInterface
{
    public function findOneByShipmentNumber(string $shipmentNumber): ?Shipment
    {
        return $this->createQueryBuilder('shipment')
            ->where('shipment.shipmentNumber = :shipmentNumber')
            ->setParameter('shipmentNumber', $shipmentNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByUuid(ShipmentId $shipmentId): ?Shipment
    {
        return $this->createQueryBuilder('shipment')
            ->where('shipment.uuid = :id')
            ->setParameter('id', $shipmentId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getOneByShipmentNumber(string $shipmentNumber): Shipment
    {
        $shipment = $this->findOneByShipmentNumber($shipmentNumber);

        if (!$shipment) {
            throw new ShipmentNotFoundException();
        }

        return $shipment;
    }

    public function getOneByUuid(ShipmentId $shipmentId): Shipment
    {
        $shipment = $this->findOneByUuid($shipmentId);

        if (!$shipment) {
            throw new ShipmentNotFoundException();
        }

        return $shipment;
    }

    public function save(Shipment $shipment): void
    {
        $this->_em->persist($shipment);
        $this->_em->flush();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shipment::class);
    }
}
