<?php

namespace ByTIC\Queue\Connections\Traits;

use ByTIC\Queue\Messages\Message;
use ByTIC\Queue\Messages\MessageTransform;
use Interop\Queue\Destination;
use Interop\Queue\Message as InteropMessage;

/**
 * Trait ConnectionSendTrait
 * @package ByTIC\Queue\Connections\Traits
 */
trait ConnectionSendTrait
{

    /**
     * @param Message $message
     * @param $queue
     * @throws \Interop\Queue\Exception
     * @throws \Interop\Queue\Exception\InvalidDestinationException
     * @throws \Interop\Queue\Exception\InvalidMessageException
     */
    public function sendOn(Message $message, $queue)
    {
        $destination = $this->createDestinationQueue($queue);
        $this->send($message, $destination);
    }

    /**
     * @param Message $message
     * @param $queue
     * @param $delay
     * @throws \Interop\Queue\Exception
     * @throws \Interop\Queue\Exception\InvalidDestinationException
     * @throws \Interop\Queue\Exception\InvalidMessageException
     */
    public function laterOn(Message $message, $queue, $delay)
    {
        $message->setDelay($delay);
        $this->sendOn($message, $queue);
    }

    /**
     * @param Message|InteropMessage $message
     * @param Destination|null $destination
     * @throws \Interop\Queue\Exception
     * @throws \Interop\Queue\Exception\InvalidDestinationException
     * @throws \Interop\Queue\Exception\InvalidMessageException
     */
    public function send(Message $message, Destination $destination = null)
    {
        $destination = $destination ?: $this->destination ?: $this->createDestinationQueue();
        $message = MessageTransform::transform($message, $this->context);
        $this->getProducer()->send($destination, $message);
    }
}
