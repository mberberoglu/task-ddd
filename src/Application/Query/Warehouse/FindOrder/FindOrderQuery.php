<?php

namespace App\Application\Query\Warehouse\FindOrder;

use App\Domain\User\ValueObject\UserId;

class FindOrderQuery
{
    /**
     * @var string
     */
    public $companyPrefix;

    /**
     * @var string
     */
    public $orderNumber;

    /**
     * @var UserId
     */
    public $userId;

    /**
     * GetOrderQuery constructor.
     */
    public function __construct(string $globalOrderNumber, ?UserId $userId = null)
    {
        $this->companyPrefix = substr($globalOrderNumber, 0, 3);
        $this->orderNumber = substr($globalOrderNumber, 3);

        $this->userId = $userId;
    }
}
