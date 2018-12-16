<?php

namespace App\Domain\Company\Factory;

use App\Domain\Company\Model\Company;
use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\User\Model\User;

/**
 * Interface CompanyFactoryInterface.
 */
interface CompanyFactoryInterface
{
    public function establish(CompanyId $uuid, User $user, string $name, string $type, string $prefix): Company;
}
