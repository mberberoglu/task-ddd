<?php

namespace App\Domain\Warehouse\Model;

use App\Domain\Common\ValueObject\AggregateRoot;
use App\Domain\Common\ValueObject\AggregateRootId;
use App\Domain\Company\Model\Company;
use App\Domain\User\Model\User;
use App\Domain\Warehouse\Event\ShipmentWasCreated;
use App\Domain\Warehouse\Event\ShipmentWasDelivered;
use App\Domain\Warehouse\ValueObject\ShipmentId;
use App\Domain\Warehouse\ValueObject\ShipmentState;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Shipment.
 */
class Shipment extends AggregateRoot
{
    /** @var ShipmentId */
    protected $uuid;

    /** @var string */
    protected $shipmentNumber;

    /** @var Shipment */
    private $parent;

    /** @var Order */
    private $order;

    /** @var Company */
    private $company;

    /** @var User */
    private $user;

    /** @var string */
    private $state;

    /** @var string */
    private $type;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var \DateTime|null */
    private $deliveredAt;

    /**
     * Shipment constructor.
     *
     * @throws \Exception
     */
    public function __construct(ShipmentId $shipmentId, string $shipmentNumber, Order $order, Company $company, User $user, string $shipmentType)
    {
        parent::__construct($shipmentId);
        $this->shipmentNumber = $shipmentNumber;
        $this->order = $order;
        $this->company = $company;
        $this->user = $user;
        $this->type = $shipmentType;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->state = ShipmentState::TRANSFERRING;
    }

    /**
     * @throws \Exception
     */
    public static function create(ShipmentId $shipmentId, string $shipmentNumber, Order $order, Company $company, User $user, string $shipmentType): self
    {
        $shipment = new self($shipmentId, $shipmentNumber, $order, $company, $user, $shipmentType);

        $shipment->raise(new ShipmentWasCreated($shipment));

        return $shipment;
    }

    public function uuid(): AggregateRootId
    {
        return ($this->uuid instanceof UuidInterface) ? new ShipmentId($this->uuid->toString()) : $this->uuid;
    }

    public function shipmentNumber(): string
    {
        return $this->shipmentNumber;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function globalShipmentNumber(): string
    {
        return sprintf('%s%s', $this->company->prefix(), $this->shipmentNumber);
    }

    public function order(): Order
    {
        return $this->order;
    }

    public function company(): Company
    {
        return $this->company;
    }

    /**
     * @return User
     */
    public function user(): string
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function userCanAccess(User $user)
    {
        return $this->user->uuid()->equals($user->uuid());
    }

    /**
     * @return bool
     */
    public function companyCanAccess(Company $company)
    {
        return $this->company->uuid()->equals($company->uuid());
    }

    public function is(): string
    {
        return $this->state;
    }

    public function setParent(self $shipment)
    {
        $this->parent = $shipment;
    }

    public function deliver()
    {
        $this->deliveredAt = new \DateTime();

        $this->raise(new ShipmentWasDelivered($this));
    }
}
