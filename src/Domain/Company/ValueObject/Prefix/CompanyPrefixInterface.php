<?php

namespace App\Domain\Company\ValueObject\Prefix;

interface CompanyPrefixInterface
{
    /**
     * @return CompanyPrefixInterface
     */
    public static function fromString(string $prefix): self;

    public function toString(): string;

    public function __toString(): string;
}
