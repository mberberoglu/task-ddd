<?php

namespace App\Domain\Security\ValueObject;

/**
 * Interface EncodedPasswordInterface.
 */
interface EncodedPasswordInterface
{
    public static function init(string $plainPassword): self;

    public function matchHash(string $hash): bool;

    public function __toString(): string;
}
