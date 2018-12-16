<?php

namespace App\Application\Command\Warehouse\CancelOrder;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Command\Warehouse\CreateShipment\CreateShipmentCommand;
use App\Application\Command\Warehouse\InventoryChange\InventoryChangeCommand;
use App\Application\Query\Warehouse\FindOrder\FindOrderQuery;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;
use App\Domain\Warehouse\ValueObject\OrderState;
use App\Domain\Warehouse\ValueObject\ShipmentType;
use League\Tactician\CommandBus;

class CancelOrderHandler implements CommandHandlerInterface
{
    public function __invoke(CancelOrderCommand $command): void
    {
        /** @var Order $order */
        $order = $this->queryBus->handle(new FindOrderQuery($command->globalOrderNumber(), $command->userId));

        switch ($order->is()) {
            case OrderState::PENDING:
            case OrderState::TRANSFERRING:
                foreach ($order->items() as $orderItem) {
                    $this->commandBus->handle(new InventoryChangeCommand($orderItem->product(), $orderItem->quantity()));
                }

                break;
            case OrderState::DELIVERED:
                $this->commandBus->handle(new CreateShipmentCommand($order, $order->shipment()->company(), $order->user(), ShipmentType::RETURN));

                break;
        }
        $order->cancel();
        $this->orderRepository->save($order);
    }

    public function __construct(CommandBus $commandBus, CommandBus $queryBus, OrderRepositoryInterface $orderRepository)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var CommandBus
     */
    private $queryBus;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
}
