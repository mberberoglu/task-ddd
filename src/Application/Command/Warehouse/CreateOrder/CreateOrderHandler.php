<?php

namespace App\Application\Command\Warehouse\CreateOrder;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Command\Warehouse\InventoryChange\InventoryChangeCommand;
use App\Domain\Warehouse\Exception\InvalidProductQuantityException;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;
use App\Domain\Warehouse\ValueObject\ProductOrderQuantity;
use League\Tactician\CommandBus;

class CreateOrderHandler implements CommandHandlerInterface
{
    public function __invoke(CreateOrderCommand $command): void
    {
        do {
            $orderNumber = random_int(10000, 99999) . random_int(1000, 9999);
        } while ($this->orderRepository->findOneByOrderNumber($orderNumber));

        $order = Order::create($command->orderId, $orderNumber, $command->company, $command->user, $command->address);

        foreach ($command->productItems as $productOrderQuantity) {
            $order->applyOrderItems($productOrderQuantity);
        }

        $changedProductItems = [];
        $exception = null;
        /** @var ProductOrderQuantity $productItem */
        foreach ($command->productItems as $productItem) {
            try {
                $this->commandBus->handle(new InventoryChangeCommand($productItem->product(), -1 * $productItem->quantity()));
            } catch (InvalidProductQuantityException $e) {
                $exception = $e;

                break;
            }
            $changedProductItems[] = $productItem;
        }

        if ($exception) {
            /** @var ProductOrderQuantity $productItem */
            foreach ($changedProductItems as $productItem) {
                $this->commandBus->handle(new InventoryChangeCommand($productItem->product(), $productItem->quantity()));
            }

            throw $exception;
        }

        $this->orderRepository->save($order);
    }

    public function __construct(CommandBus $commandBus, OrderRepositoryInterface $orderRepository)
    {
        $this->commandBus = $commandBus;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
}
