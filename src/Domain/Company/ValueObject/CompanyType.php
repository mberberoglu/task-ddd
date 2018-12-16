<?php

namespace App\Domain\Company\ValueObject;

use Assert\Assertion;

class CompanyType
{
    /**
     * @throws \Assert\AssertionFailedException
     *
     * @return CompanyType
     */
    public static function fromString(string $type): self
    {
        Assertion::choice($type, ['cargo', 'merchant']);

        $company = new self();

        $company->type = $type;

        return $company;
    }

    public function toString(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    private function __construct()
    {
    }

    /** @var string */
    private $type;
}
