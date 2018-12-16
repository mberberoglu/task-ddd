<?php

namespace App\Application\Command\Warehouse\CreateShipment;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Warehouse\Model\Shipment;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;
use App\Domain\Warehouse\Repository\ShipmentRepositoryInterface;
use App\Domain\Warehouse\ValueObject\ShipmentType;

class CreateShipmentHandler implements CommandHandlerInterface
{
    public function __invoke(CreateShipmentCommand $command): void
    {
        do {
            $shipmentNumber = random_int(10000, 99999) . random_int(1000, 9999);
        } while ($this->shipmentRepository->findOneByShipmentNumber($shipmentNumber));

        $shipment = Shipment::create($command->shipmentId, $shipmentNumber, $command->order, $command->company, $command->user, $command->type);

        $order = $command->order;

        if (ShipmentType::RETURN == $shipment->type()) {
            $shipment->setParent($order->shipment());
            $order->startReturn($shipment);
        } else {
            $order->startShipment($shipment);
        }

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
