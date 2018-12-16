<?php

namespace App\Application\Query\Warehouse\FindProduct;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Warehouse\Model\Product;
use App\Domain\Warehouse\Repository\ProductRepositoryInterface;

class FindProductHandler implements QueryHandlerInterface
{
    public function __invoke(FindProductQuery $query): Product
    {
        return $this->repository->findOneByUuid($query->productId);
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
