<?php

namespace App\Application\Command\Warehouse\UpdateOrderItem;

use App\Application\Command\CommandHandlerInterface;
use App\Application\Command\Warehouse\InventoryChange\InventoryChangeCommand;
use App\Domain\Warehouse\Repository\OrderItemRepositoryInterface;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;
use App\Domain\Warehouse\ValueObject\ProductOrderQuantity;
use League\Tactician\CommandBus;

class UpdateProductOrderItemHandler implements CommandHandlerInterface
{
    public function __invoke(UpdateProductOrderItemCommand $command): void
    {
        $order = $this->orderRepository->getOneByUuid($command->order->uuid());

        $item = $order->getOrderItem($command->product->uuid());
        $oldQuantity = ($item) ? $item->quantity() : 0;
        $order->applyOrderItems(new ProductOrderQuantity($command->product, $command->quantity));

        if ($item) {
            $this->commandBus->handle(new InventoryChangeCommand($command->product, (-1 * $command->quantity) + $oldQuantity));
            if (0 == $command->quantity) {
                $this->orderItemRepository->remove($item);
            }
        } else {
            $this->commandBus->handle(new InventoryChangeCommand($command->product, -1 * $command->quantity));
        }

        $this->orderRepository->save($order);
    }

    public function __construct(CommandBus $commandBus, OrderRepositoryInterface $orderRepository, OrderItemRepositoryInterface $orderItemRepository)
    {
        $this->commandBus = $commandBus;
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var OrderItemRepositoryInterface
     */
    private $orderItemRepository;
}
