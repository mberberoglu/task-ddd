<?php

namespace App\Application\Query\Warehouse\FindOrder;

use App\Application\Query\QueryHandlerInterface;
use App\Domain\Company\Repository\CompanyRepositoryInterface;
use App\Domain\Company\ValueObject\Prefix\AbstractCompanyPrefix;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixFactory;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\Warehouse\Exception\OrderNotFoundException;
use App\Domain\Warehouse\Model\Order;
use App\Domain\Warehouse\Repository\OrderRepositoryInterface;

class FindOrderHandler implements QueryHandlerInterface
{
    /**
     * @throws OrderNotFoundException
     * @throws \App\Domain\Company\Exception\CompanyNotFoundException
     */
    public function __invoke(FindOrderQuery $query): Order
    {
        $order = $this->repository->getOneByOrderNumber($query->orderNumber);

        if ($query->userId) {
            $user = $this->userRepository->getOneByUuid($query->userId);
            if (!$order->userCanAccess($user)) {
                throw new OrderNotFoundException();
            }
        }

        $company = $this->companyRepository->getOneByPrefix(CompanyPrefixFactory::make(AbstractCompanyPrefix::MERCHANT)::fromString($query->companyPrefix));

        if (!$order->companyCanAccess($company)) {
            throw new OrderNotFoundException();
        }

        return $order;
    }

    public function __construct(OrderRepositoryInterface $repository, UserRepositoryInterface $userRepository, CompanyRepositoryInterface $companyRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @var OrderRepositoryInterface
     */
    private $repository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var CompanyRepositoryInterface
     */
    private $companyRepository;
}
