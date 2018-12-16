<?php

namespace App\Infrastructure\Warehouse\Repository;

use App\Domain\Warehouse\Exception\OrderNotFoundException;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;
use App\Domain\Warehouse\ValueObject\OrderId;
use App\Domain\Warehouse\ValueObject\OrderState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class OrderRepository.
 */
class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function findOneByOrderNumber(string $orderNumber): ?Order
    {
        return $this->createQueryBuilder('o')
            ->where('o.orderNumber = :orderNumber')
            ->setParameter('orderNumber', $orderNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByUuid(OrderId $orderId): ?Order
    {
        return $this->createQueryBuilder('o')
            ->where('o.uuid = :id')
            ->setParameter('id', $orderId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getOneByOrderNumber(string $orderNumber): Order
    {
        $order = $this->findOneByOrderNumber($orderNumber);

        if (!$order) {
            throw new OrderNotFoundException();
        }

        return $order;
    }

    public function getOneByUuid(OrderId $orderId): Order
    {
        $order = $this->findOneByUuid($orderId);

        if (!$order) {
            throw new OrderNotFoundException();
        }

        return $order;
    }

    public function findAllShipmentWaiting(int $from = 0, int $limit = 50)
    {
        return $this->createQueryBuilder('o')
            ->where('o.state = :state')
            ->setParameter('state', OrderState::PENDING)
            ->getQuery()
            ->getResult();
    }

    public function countAllShipmentWaiting(): int
    {
        try {
            return (int) $this->createQueryBuilder('o')
                ->select('COUNT(o.uuid)')
                ->where('o.state = :state')
                ->setParameter('state', OrderState::PENDING)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }

    public function save(Order $order): void
    {
        $this->_em->persist($order);
        $this->_em->flush();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }
}
