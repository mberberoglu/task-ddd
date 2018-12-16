<?php

namespace App\Infrastructure\Common\Bus\Middleware;

use App\Domain\Common\Event\EventDispatcherInterface;
use League\Tactician\Middleware;

class EventDispatcherMiddleware implements Middleware
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        $this->eventDispatcher->dispatch();

        return $returnValue;
    }
}
