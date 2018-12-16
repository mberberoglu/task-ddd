<?php

namespace App\Domain\Company\Model;

use App\Domain\Common\ValueObject\AggregateRoot;
use App\Domain\Common\ValueObject\AggregateRootId;
use App\Domain\Company\Event\CompanyWasCreated;
use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\Company\ValueObject\CompanyType;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixFactory;
use App\Domain\Company\ValueObject\Prefix\CompanyPrefixInterface;
use App\Domain\User\Model\User;
use Ramsey\Uuid\UuidInterface;

class Company extends AggregateRoot
{
    /** @var CompanyId */
    protected $uuid;

    /** @var User */
    private $user;

    /** @var string */
    private $name;

    /** @var CompanyType */
    private $type;

    /** @var CompanyPrefixInterface */
    private $prefix;

    /** @var \DateTime */
    private $createdAt;

    /** @var \DateTime */
    private $updatedAt;

    public function __construct(
        CompanyId $companyId,
        User $user,
        string $name,
        string $companyType,
        string $prefix
    ) {
        parent::__construct($companyId);

        $this->name = $name;
        $this->user = $user;
        $this->setType($companyType);
        $this->setPrefix($prefix);
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public static function create(
        CompanyId $companyId,
        User $user,
        string $name,
        string $companyType,
        string $prefix
    ): self {
        $company = new self($companyId, $user, $name, $companyType, $prefix);

        $company->raise(new CompanyWasCreated($company));

        return $company;
    }

    public function uuid(): AggregateRootId
    {
        return ($this->uuid instanceof UuidInterface) ? new CompanyId($this->uuid->toString()) : $this->uuid;
    }

    private function setType(string $type)
    {
        $this->type = CompanyType::fromString($type);
    }

    private function setPrefix(string $prefix)
    {
        $this->prefix = CompanyPrefixFactory::make($this->type)::fromString($prefix);
    }

    public function type(): CompanyType
    {
        return ($this->type instanceof CompanyType) ? $this->type : CompanyType::fromString($this->type);
    }

    public function user(): User
    {
        return $this->user;
    }

    public function prefix(): CompanyPrefixInterface
    {
        return ($this->prefix instanceof CompanyPrefixInterface) ? $this->prefix : CompanyPrefixFactory::make($this->type)::fromString($this->prefix);
    }

    public function name(): string
    {
        return $this->name;
    }

    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
