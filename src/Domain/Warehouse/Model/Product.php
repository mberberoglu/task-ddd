<?php

namespace App\Domain\Warehouse\Model;

use App\Domain\Common\ValueObject\AggregateRoot;
use App\Domain\Common\ValueObject\AggregateRootId;
use App\Domain\Company\Model\Company;
use App\Domain\Warehouse\Event\ProductInventoryChanged;
use App\Domain\Warehouse\Event\ProductWasCreated;
use App\Domain\Warehouse\ValueObject\ProductId;
use Ramsey\Uuid\UuidInterface;

class Product extends AggregateRoot
{
    /** @var ProductId */
    protected $uuid;

    /** @var Company */
    private $company;

    /** @var string */
    private $name;

    /** @var int */
    private $quantity;

    /**
     * Product constructor.
     */
    public function __construct(ProductId $uuid, Company $company, string $name, int $quantity)
    {
        parent::__construct($uuid);
        $this->company = $company;
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public static function create(ProductId $uuid, Company $company, string $name): self
    {
        $product = new self($uuid, $company, $name, 0);

        $product->raise(new ProductWasCreated($product));

        return $product;
    }

    public function applyProductInventoryChanged(ProductInventoryChanged $event): void
    {
        $this->quantity += $event->quantity();

        $this->raise($event);
    }

    public function uuid(): AggregateRootId
    {
        return ($this->uuid instanceof UuidInterface) ? new ProductId($this->uuid->toString()) : $this->uuid;
    }

    public function company(): Company
    {
        return $this->company;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function quantity(): int
    {
        return $this->quantity;
    }
}
