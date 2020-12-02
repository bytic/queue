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
     */
    public function laterOn(Message $message, $queue, $delay)
    {
        $message->setDelay($delay);
        $this->sendOn($message, $queue);
    }

    /**
     * @param Message|InteropMessage $message
     * @param Destination|null $destination
     */
    public function send(Message $message, Destination $destination = null)
    {
        $destination = $this->sendDetectDestination($destination);
        $message = MessageTransform::transform($message, $this->context, $destination);
        $this->getProducer()->send($destination, $message);
    }

    /**
     * @param Destination|null $destination
     * @return Destination|mixed
     */
    protected function sendDetectDestination(Destination $destination = null)
    {
        if ($destination instanceof Destination) {
            return $destination;
        }
        if (isset($this->destination) && $this->destination instanceof Destination) {
            return $this->destination;
        }
        return $this->createDestinationQueue();
    }

    /**
     * @param null $name
     * @return mixed
     */
    abstract public function createDestinationQueue($name = null);
}
