<?php

namespace App\Domain\Warehouse\Repository;

use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Warehouse\Model\Product;
use App\Domain\Warehouse\ValueObject\ProductId;

interface ProductRepositoryInterface
{
    public function findAllByCompany(CompanyId $companyId, int $from = 0, int $limit = 50);

    public function countByCompany(CompanyId $companyId): int;

    public function getOneByUuid(ProductId $productId): Product;

    public function findOneByUuid(ProductId $productId): ?Product;

    public function save(Product $product): void;
}
