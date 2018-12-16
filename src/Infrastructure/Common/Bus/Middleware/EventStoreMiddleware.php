<?php

namespace App\Infrastructure\Common\Bus\Middleware;

use App\Domain\Common\Event\EventCollector;
use App\Infrastructure\Common\Event\EventAware;
use App\Infrastructure\Common\Repository\EventStoreRepository;
use League\Tactician\Middleware;

class EventStoreMiddleware implements Middleware
{
    /**
     * @var EventStoreRepository
     */
    private $eventStoreRepository;

    /**
     * @var EventCollector
     */
    private $eventCollector;

    public function __construct(EventStoreRepository $eventStoreRepository, EventCollector $eventCollector)
    {
        $this->eventStoreRepository = $eventStoreRepository;
        $this->eventCollector = $eventCollector;
    }

    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        $events = $this->eventCollector->events();

        foreach ($events as $event) {
            $symfonyEvent = new EventAware($event);
            $this->eventStoreRepository->store($symfonyEvent);
        }

        return $returnValue;
    }
}
