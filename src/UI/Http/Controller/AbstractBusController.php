<?php

namespace App\UI\Http\Controller;

use App\Infrastructure\Security\Security\Model\Auth;
use JMS\Serializer\SerializerInterface;
use League\Tactician\CommandBus;
use Symfony\Component\Security\Core\Security;

abstract class AbstractBusController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var CommandBus
     */
    private $queryBus;

    /** @var Security */
    private $security;

    public function __construct(CommandBus $bus, CommandBus $queryBus, SerializerInterface $serializer, Security $security)
    {
        $this->bus = $bus;
        $this->queryBus = $queryBus;
        $this->serializer = $serializer;
        $this->security = $security;
    }

    /**
     * @param object $commandRequest
     */
    public function handle($commandRequest)
    {
        return $this->bus->handle($commandRequest);
    }

    /**
     * @param object $commandRequest
     */
    public function ask($commandRequest)
    {
        return $this->queryBus->handle($commandRequest);
    }

    protected function getUser(): ?Auth
    {
        return $this->security->getUser();
    }
}
