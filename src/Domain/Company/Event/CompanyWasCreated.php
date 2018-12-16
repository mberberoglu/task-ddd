<?php

namespace App\Domain\Company\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Company\Model\Company;

class CompanyWasCreated extends AbstractEvent
{
    /**
     * @var string
     */
    protected $companyId;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var string
     */
    private $name;

    /**
     * CompanyWasCreated constructor.
     */
    public function __construct(Company $company)
    {
        parent::__construct();
        $this->companyId = $company->uuid()->toString();
        $this->type = $company->type()->toString();
        $this->prefix = $company->prefix()->toString();
        $this->name = $company->name();
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function prefix(): string
    {
        return $this->prefix;
    }

    public function name(): string
    {
        return $this->name;
    }
}
