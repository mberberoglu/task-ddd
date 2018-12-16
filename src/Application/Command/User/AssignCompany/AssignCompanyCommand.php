<?php

namespace App\Application\Command\User\AssignCompany;

use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\User\ValueObject\UserId;

class AssignCompanyCommand
{
    /**
     * @var UserId
     */
    public $userId;
    /**
     * @var CompanyId
     */
    public $companyId;

    /**
     * AssignCompanyCommand constructor.
     */
    public function __construct(UserId $userId, CompanyId $companyId)
    {
        $this->userId = $userId;
        $this->companyId = $companyId;
    }
}
