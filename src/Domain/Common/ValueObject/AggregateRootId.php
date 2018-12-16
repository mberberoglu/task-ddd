<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Exception\InvalidUUIDException;
use Ramsey\Uuid\Uuid;

/**
 * Class AggregateRootId.
 *
 * Its the unique identifier and will be auto-generated if not value is set.
 */
abstract class AggregateRootId
{
    /**
     * @var string
     */
    protected $uuid;

    public function __construct(?string $id = null)
    {
        try {
            $this->uuid = Uuid::fromString($id ?: (string) Uuid::uuid4())->toString();
        } catch (\InvalidArgumentException $e) {
            throw new InvalidUUIDException();
        }
    }

    public function equals(self $aggregateRootId): bool
    {
        return $this->uuid === $aggregateRootId->toString();
    }

    public function bytes(): string
    {
        return Uuid::fromString($this->uuid)->getBytes();
    }

    public static function fromBytes(string $bytes): self
    {
        return new static(Uuid::fromBytes($bytes)->toString());
    }

    public static function toBytes(string $uid): string
    {
        return (new static($uid))->bytes();
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
