<?php

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Event\EventInterface;
use App\Domain\Common\Event\EventPublisher;
use App\Domain\User\ValueObject\UserId;
use Ramsey\Uuid\UuidInterface;

abstract class AggregateRoot
{
    /**
     * @var AggregateRootId
     */
    protected $uuid;

    protected function __construct(AggregateRootId $aggregateRootId)
    {
        $this->uuid = $aggregateRootId;
    }

    public function uuid(): AggregateRootId
    {
        return ($this->uuid instanceof UuidInterface) ? new UserId($this->uuid->toString()) : $this->uuid;
    }

    final public function equals(AggregateRootId $aggregateRootId)
    {
        return $this->uuid->equals($aggregateRootId);
    }

    final protected function raise(EventInterface $event): void
    {
        EventPublisher::raise($event);
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }
}
