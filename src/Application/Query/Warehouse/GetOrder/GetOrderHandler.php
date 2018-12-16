<?php

namespace App\Application\Query\Warehouse\GetOrder;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;

class GetOrderHandler implements QueryHandlerInterface
{
    public function __invoke(GetOrderQuery $query): Order
    {
        return $this->repository->getOneByUuid($query->orderId);
    }

    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @var OrderRepositoryInterface
     */
    private $repository;
}
