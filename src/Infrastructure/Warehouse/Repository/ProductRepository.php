<?php

namespace App\Infrastructure\Warehouse\Repository;

use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Warehouse\Exception\ProductNotFoundException;
use App\Domain\Warehouse\Model\Product;
use App\Domain\Warehouse\Repository\ProductRepositoryInterface;
use App\Domain\Warehouse\ValueObject\ProductId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Class ProductRepository.
 */
class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    /**
     * @return Product[]
     */
    public function findAllByCompany(CompanyId $companyId, int $from = 0, int $limit = 50)
    {
        return $this->createQueryBuilder('product')
            ->join('product.company', 'company')
            ->where('company.uuid = :id')
            ->setParameter('id', $companyId)
            ->setFirstResult($from)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countByCompany(CompanyId $companyId): int
    {
        try {
            return (int) $this->createQueryBuilder('product')
                ->select('COUNT(product.uuid)')
                ->join('product.company', 'company')
                ->where('company.uuid = :id')
                ->setParameter('id', $companyId)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }

    public function findOneByUuid(ProductId $productId): ?Product
    {
        return $this->createQueryBuilder('product')
            ->where('product.uuid = :id')
            ->setParameter('id', $productId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getOneByUuid(ProductId $productId): Product
    {
        $product = $this->findOneByUuid($productId);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product;
    }

    public function save(Product $product): void
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }
}
