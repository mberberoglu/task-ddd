<?php

namespace App\Domain\Warehouse\Model;

use App\Domain\Common\ValueObject\AggregateRoot;
use App\Domain\Common\ValueObject\AggregateRootId;
use App\Domain\Company\Model\Company;
use App\Domain\User\Model\User;
use App\Domain\Warehouse\Event\OrderAddressWasUpdated;
use App\Domain\Warehouse\Event\OrderItemWasUpdated;
use App\Domain\Warehouse\Event\OrderWasCancelled;
use App\Domain\Warehouse\Event\OrderWasCreated;
use App\Domain\Warehouse\Event\ShipmentWasStarted;
use App\Domain\Warehouse\Exception\InvalidOrderStateException;
use App\Domain\Warehouse\ValueObject\OrderId;
use App\Domain\Warehouse\ValueObject\OrderState;
use App\Domain\Warehouse\ValueObject\ProductId;
use App\Domain\Warehouse\ValueObject\ProductOrderQuantity;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\UuidInterface;

class Order extends AggregateRoot
{
    /** @var OrderId */
    protected $uuid;

    /** @var string */
    protected $orderNumber;

    /** @var Company */
    private $company;

    /** @var Shipment */
    private $shipment;

    /** @var User */
    private $user;

    /** @var string */
    private $address;

    /** @var string */
    private $state;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    /** @var ArrayCollection|OrderItem[] */
    private $items;

    /**
     * Order constructor.
     *
     * @throws \Exception
     */
    public function __construct(OrderId $orderId, string $orderNumber, Company $company, User $user, string $address)
    {
        parent::__construct($orderId);
        $this->orderNumber = $orderNumber;
        $this->company = $company;
        $this->user = $user;
        $this->address = $address;
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->items = new ArrayCollection();
        $this->state = OrderState::PENDING;
    }

    /**
     * @throws \Exception
     */
    public static function create(OrderId $orderId, string $orderNumber, Company $company, User $user, string $address): self
    {
        $order = new self($orderId, $orderNumber, $company, $user, $address);

        $order->raise(new OrderWasCreated($order));

        return $order;
    }

    public function getOrderItem(ProductId $productId): ?OrderItem
    {
        foreach ($this->items as $key => $item) {
            if ($item->product()->uuid()->equals($productId)) {
                return $item;
            }
        }

        return null;
    }

    public function applyOrderItems(ProductOrderQuantity $productOrderQuantity): void
    {
        if (!OrderState::can($this, OrderState::PRODUCT_UPDATING)) {
            throw new InvalidOrderStateException('Products cannot be updated');
        }
        $oldQuantity = 0;
        $orderItem = $this->getOrderItem($productOrderQuantity->product()->uuid());

        if (null !== $orderItem) {
            $oldQuantity = $orderItem->quantity();
            $orderItem->setQuantity($productOrderQuantity->quantity());
            if (0 == $orderItem->quantity()) {
                $this->items->removeElement($orderItem);
            } else {
                $this->items->set($this->items->indexOf($orderItem), $orderItem);
            }
        } else {
            $orderItem = OrderItem::create($this, $productOrderQuantity);
            $this->items->add($orderItem);
        }
        $this->raise(new OrderItemWasUpdated($orderItem, $oldQuantity));
    }

    public function startShipment(Shipment $shipment): void
    {
        if (!OrderState::can($this, OrderState::TRANSFERRING)) {
            throw new InvalidOrderStateException('Shipment already started');
        }
        $this->shipment = $shipment;
        $this->state = OrderState::TRANSFERRING;
        $this->raise(new ShipmentWasStarted($shipment));
    }

    public function startReturn(Shipment $shipment): void
    {
        if (!OrderState::can($this, OrderState::DELIVERED)) {
            throw new InvalidOrderStateException('Order cannot be return');
        }
        $this->shipment = $shipment;
        $this->state = OrderState::TRANSFERRING;
        $this->raise(new ShipmentWasStarted($shipment));
    }

    public function setAddress(string $address): void
    {
        if (!OrderState::can($this, OrderState::PRODUCT_UPDATING)) {
            throw new InvalidOrderStateException('Address cannot be updated');
        }
        $oldAddress = $this->address;
        $this->address = $address;
        $this->raise(new OrderAddressWasUpdated($this->uuid(), $this->address, $oldAddress));
    }

    public function cancel(): void
    {
        if (!OrderState::can($this, OrderState::CANCELLED)) {
            throw new InvalidOrderStateException('Order cannot be cancelled');
        }

        $this->state = OrderState::CANCELLED;
        $this->raise(new OrderWasCancelled($this));
    }

    public function uuid(): AggregateRootId
    {
        return ($this->uuid instanceof UuidInterface) ? new OrderId($this->uuid->toString()) : $this->uuid;
    }

    public function orderNumber(): string
    {
        return $this->orderNumber;
    }

    public function globalOrderNumber(): string
    {
        return sprintf('%s%s', $this->company->prefix(), $this->orderNumber);
    }

    public function company(): Company
    {
        return $this->company;
    }

    public function shipment(): Shipment
    {
        return $this->shipment;
    }

    /**
     * @return User
     */
    public function user(): string
    {
        return $this->user;
    }

    /**
     * @return OrderItem[]|ArrayCollection
     */
    public function items()
    {
        return $this->items;
    }

    public function address(): string
    {
        return $this->address;
    }

    public function userCanAccess(User $user)
    {
        return $this->user->uuid()->equals($user->uuid());
    }

    public function companyCanAccess(Company $company)
    {
        return $this->company->uuid()->equals($company->uuid());
    }

    public function is(): string
    {
        return $this->state;
    }

    public function deliver()
    {
        if (!OrderState::can($this, OrderState::DELIVERED)) {
            throw new InvalidOrderStateException('Order cannot be delivered');
        }
        $this->state = OrderState::DELIVERED;
        $this->shipment->deliver();
    }
}
