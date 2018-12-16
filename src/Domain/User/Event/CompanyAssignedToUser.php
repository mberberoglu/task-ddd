<?php

namespace App\Domain\User\Event;

use App\Domain\Common\Event\AbstractEvent;
use App\Domain\Company\Model\Company;
use App\Domain\User\Model\User;

class CompanyAssignedToUser extends AbstractEvent
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Company
     */
    private $company;

    public function __construct(User $user, Company $company)
    {
        parent::__construct();
        $this->user = $user;
        $this->company = $company;
    }
}
