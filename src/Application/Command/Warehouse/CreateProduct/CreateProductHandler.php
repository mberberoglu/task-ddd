<?php

namespace App\Application\Command\Warehouse\CreateProduct;

use App\Application\Command\CommandHandlerInterface;
use App\Domain\Warehouse\Model\Product;
use App\Domain\Warehouse\Repository\ProductRepositoryInterface;

class CreateProductHandler implements CommandHandlerInterface
{
    public function __invoke(CreateProductCommand $command): void
    {
        $product = Product::create($command->productId, $command->company, $command->name);

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
