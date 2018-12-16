<?php

namespace App\Application\Command\Company\Establish;

use App\Domain\Company\ValueObject\CompanyId;
use App\Domain\User\Model\User;

class EstablishCommand
{
    /**
     * @var CompanyId
     */
    public $uuid;
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $prefix;

    /**
     * EstablishCommand constructor.
     */
    public function __construct(CompanyId $uuid, User $user, string $name, string $type, string $prefix)
    {
        $this->uuid = $uuid;
        $this->user = $user;
        $this->name = $name;
        $this->type = $type;
        $this->prefix = $prefix;
    }
}
