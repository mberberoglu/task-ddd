<?php

namespace App\Domain\Company\ValueObject\Prefix;

abstract class AbstractCompanyPrefix implements CompanyPrefixInterface
{
    const CARGO = 'cargo';
    const MERCHANT = 'merchant';

    public function toString(): string
    {
        return $this->prefix;
    }

    public function __toString(): string
    {
        return $this->prefix;
    }

    /** @var string */
    protected $prefix;
}
