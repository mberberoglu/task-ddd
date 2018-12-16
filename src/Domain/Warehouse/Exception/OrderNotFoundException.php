<?php

namespace App\Domain\Warehouse\Exception;

use App\Domain\Common\Exception\NotFoundException;

/**
 * Class OrderNotFoundException.
 */
class OrderNotFoundException extends NotFoundException
{
    /**
     * UserNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('order.exception.not_found', 5004);
    }
}
