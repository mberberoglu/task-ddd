<?php

namespace App\Domain\Company\ValueObject\Prefix;

use App\Domain\Company\ValueObject\Prefix\Type\Cargo;
use App\Domain\Company\ValueObject\Prefix\Type\Merchant;

class CompanyPrefixFactory
{
    /**
     * The list of products supported by the factory.
     *
     * @var array
     */
    protected static $types = [
        AbstractCompanyPrefix::CARGO    => Cargo::class,
        AbstractCompanyPrefix::MERCHANT => Merchant::class,
    ];

    /**
     * Make a new concrete class for the given type.
     *
     *
     * @param string $type
     * @return CompanyPrefixInterface
     */
    public static function make(string $type): CompanyPrefixInterface
    {
        if (array_key_exists($type, self::$types)) {
            $class = self::$types[$type];

            return new $class();
        }

        throw new \InvalidArgumentException("The [{$type}] type is not supported!");
    }
}
