<?php

namespace App\Domain\Company\Exception;

use App\Domain\Common\Exception\NotFoundException;

/**
 * Class CompanyNotFoundException.
 */
class CompanyNotFoundException extends NotFoundException
{
    /**
     * UserNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('company.exception.not_found', 3004);
    }
}
