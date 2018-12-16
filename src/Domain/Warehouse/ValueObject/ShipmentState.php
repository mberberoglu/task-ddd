<?php

namespace App\Domain\Warehouse\ValueObject;

use App\Domain\Warehouse\Model\Order;

/**
 * Class ShipmentState.
 */
class ShipmentState
{
    const
        TRANSFERRING = 'transferring';
    const DELIVERED = 'delivered';
    const CANCELLED = 'cancelled'
    ;

    public static function can(Order $order, string $new): bool
    {
        $can = false;

        $current = $order->is();

        switch ($new) {
            case self::CANCELLED:
                $can = self::canCancel($current);

                break;
        }

        return $can;
    }

    private static function canCancel(string $state): bool
    {
        return $state === static::DELIVERED;
    }
}
