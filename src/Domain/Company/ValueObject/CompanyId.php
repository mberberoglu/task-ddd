<?php

namespace App\Domain\Company\ValueObject;

use App\Domain\Common\ValueObject\AggregateRootId;

class CompanyId extends AggregateRootId
{
    /** @var string */
    protected $uuid;
}
