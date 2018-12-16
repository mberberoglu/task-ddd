<?php

namespace App\Application\Command\Warehouse\InventoryChange;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Warehouse\Event\ProductInventoryChanged;
use App\Domain\Warehouse\Exception\InvalidProductQuantityException;
use App\Domain\Warehouse\Repository\ProductRepositoryInterface;

class InventoryChangeHandler implements CommandHandlerInterface
{
    public function __invoke(InventoryChangeCommand $command): void
    {
        $product = $this->productRepository->getOneByUuid($command->product->uuid());

        $quantity = $product->quantity() + $command->quantity;
        if ($quantity < 0) {
            throw new InvalidProductQuantityException('No product left!');
        }
        $product->applyProductInventoryChanged(new ProductInventoryChanged($command->product->uuid(), $command->quantity));

        $this->productRepository->save($product);
    }

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
}
