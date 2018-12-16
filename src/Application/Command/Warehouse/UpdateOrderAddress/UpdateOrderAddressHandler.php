<?php

namespace App\Application\Command\Warehouse\UpdateOrderAddress;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;
use League\Tactician\CommandBus;

class UpdateOrderAddressHandler implements CommandHandlerInterface
{
    public function __invoke(UpdateOrderAddressCommand $command): void
    {
        $order = $this->orderRepository->getOneByUuid($command->order->uuid());

        if ($order->address() !== $command->address) {
            $order->setAddress($command->address);

            $this->orderRepository->save($order);
        }
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
