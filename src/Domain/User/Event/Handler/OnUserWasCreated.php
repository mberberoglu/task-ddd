<?php

namespace App\Domain\User\Event\Handler;

use Zend\EventManager\EventManagerAwareInterface;

class OnUserWasCreated
{
    public function __invoke(EventManagerAwareInterface $eventAware): void
    {
        var_dump('EMAIL');
        die;
    }
}
