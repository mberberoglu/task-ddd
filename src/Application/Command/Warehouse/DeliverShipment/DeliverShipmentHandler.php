<?php

namespace App\Application\Command\Warehouse\DeliverShipment;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;
use App\Domain\Warehouse\Repository\ShipmentRepositoryInterface;

class DeliverShipmentHandler implements CommandHandlerInterface
{
    public function __invoke(DeliverShipmentCommand $command): void
    {
        $order = $this->orderRepository->getOneByUuid($command->orderId);

        $order->deliver();

        $this->orderRepository->save($order);
    }

    public function __construct(OrderRepositoryInterface $orderRepository, ShipmentRepositoryInterface $shipmentRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->shipmentRepository = $shipmentRepository;
    }

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var ShipmentRepositoryInterface
     */
    private $shipmentRepository;
}
