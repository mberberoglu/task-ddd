<?php

namespace App\Domain\Warehouse\Exception;

use App\Domain\Common\Exception\NotFoundException;

/**
 * Class ProductNotFoundException.
 */
class ProductNotFoundException extends NotFoundException
{
    /**
     * UserNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('product.exception.not_found', 4004);
    }
}
