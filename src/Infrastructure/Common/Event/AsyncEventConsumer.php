<?php

namespace App\Infrastructure\Common\Event;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class AsyncEventConsumer implements ConsumerInterface
{
    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        // TODO
        return self::MSG_ACK;
    }
}
