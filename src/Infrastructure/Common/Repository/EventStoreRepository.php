<?php

namespace App\Infrastructure\Common\Repository;

use App\Infrastructure\Common\Event\EventAware;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class EventStoreRepository extends ServiceEntityRepository
{
    public function store(EventAware $eventAware)
    {
        $this->_em->persist($eventAware);
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventAware::class);
    }
}
