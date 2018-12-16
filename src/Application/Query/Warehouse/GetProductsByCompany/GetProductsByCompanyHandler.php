<?php

namespace App\Application\Query\Warehouse\GetProductsByCompany;

use App\Application\Query\Collection;
use App\Application\Query\QueryHandlerInterface;
use App\Domain\Warehouse\Repository\ProductRepositoryInterface;

class GetProductsByCompanyHandler implements QueryHandlerInterface
{
    public function __invoke(GetProductsByCompanyQuery $query): Collection
    {
        $products = $this->repository->findAllByCompany($query->uuid);
        $total = $this->repository->countByCompany($query->uuid);

        return new Collection($query->from, $query->limit, $total, $products);
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
