<?php

namespace App\Domain\User\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;

/**
 * Class UserId.
 */
class UserId extends AggregateRootId
{
    /** @var string */
    protected $uuid;
}
