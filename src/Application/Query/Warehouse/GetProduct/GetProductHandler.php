<?php

namespace App\Application\Query\Warehouse\GetProduct;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Warehouse\Exception\ProductNotFoundException;
use App\Domain\Warehouse\Model\Product;
use App\Domain\Warehouse\Repository\ProductRepositoryInterface;

class GetProductHandler implements QueryHandlerInterface
{
    public function __invoke(GetProductQuery $query): Product
    {
        $product = $this->repository->getOneByUuid($query->productId);

        if ($query->companyId && !$product->company()->uuid()->equals($query->companyId)) {
            throw new ProductNotFoundException();
        }

        return $product;
    }

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @var ProductRepositoryInterface
     */
    private $repository;
}
