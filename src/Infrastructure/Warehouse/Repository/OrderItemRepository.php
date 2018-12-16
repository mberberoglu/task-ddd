<?php

namespace App\Infrastructure\Warehouse\Repository;

use App\Domain\Warehouse\Model\OrderItem;
use App\Domain\Warehouse\Repository\OrderItemRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class OrderItemRepository.
 */
class OrderItemRepository extends ServiceEntityRepository implements OrderItemRepositoryInterface
{
    public function remove(OrderItem $orderItem): void
    {
        $this->_em->remove($orderItem);
        $this->_em->flush();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderItem::class);
    }
}
