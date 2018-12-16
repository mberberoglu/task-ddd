<?php

namespace App\Domain\Warehouse\Exception;

use App\Domain\Common\Exception\NotFoundException;

/**
 * Class ShipmentNotFoundException.
 */
class ShipmentNotFoundException extends NotFoundException
{
    /**
     * UserNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('shipment.exception.not_found', 6004);
    }
}
