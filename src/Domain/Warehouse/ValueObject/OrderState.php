<?php

namespace App\Domain\Warehouse\ValueObject;

use App\Domain\Warehouse\Model\Order;

/**
 * Class OrderState.
 */
class OrderState
{
    const
        PENDING = 'pending';
    const PRODUCT_UPDATING = 'product_updating';
    const TRANSFERRING = 'transferring';
    const DELIVERED = 'delivered';
    const CANCELLED = 'cancelled'
    ;

    public static function can(Order $order, string $new): bool
    {
        $can = false;

        $current = $order->is();

        switch ($new) {
            case self::PRODUCT_UPDATING:
                $can = self::canProductUpdate($current);

                break;
            case self::TRANSFERRING:
                $can = self::canTransfer($current);

                break;
            case self::CANCELLED:
                $can = self::canCancel($current);

                break;
            case self::DELIVERED:
                $can = self::canDeliver($current);

                break;
        }

        return $can;
    }

    private static function canProductUpdate(string $state): bool
    {
        return $state === static::PENDING;
    }

    private static function canTransfer(string $state): bool
    {
        return $state === static::PENDING;
    }

    private static function canCancel(string $state): bool
    {
        return $state !== static::CANCELLED;
    }

    private static function canDeliver(string $state): bool
    {
        return $state === static::TRANSFERRING;
    }
}
