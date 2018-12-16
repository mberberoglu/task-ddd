<?php

namespace App\Application\Command\Warehouse\CancelOrder;

use App\Domain\User\ValueObject\UserId;

class CancelOrderCommand
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

    public function globalOrderNumber(): string
    {
        return sprintf('%s%s', $this->companyPrefix, $this->orderNumber);
    }
}
