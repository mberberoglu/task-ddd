<?php

namespace App\Application\Query\Warehouse\GetShipmentWaitingOrders;

use App\Application\Query\Collection;
use App\Application\Query\QueryHandlerInterface;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;

class GetShipmentWaitingOrdersHandler implements QueryHandlerInterface
{
    public function __invoke(GetShipmentWaitingOrdersQuery $query): Collection
    {
        $orders = $this->repository->findAllShipmentWaiting($query->from, $query->limit);
        $total = $this->repository->countAllShipmentWaiting();

        return new Collection($query->from, $query->limit, $total, $orders);
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
