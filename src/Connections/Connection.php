<?php

namespace ByTIC\Queue\Connections;

use ByTIC\Queue\Messages\Message;
use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Message as InteropMessage;
use Interop\Queue\Producer;

/**
 * Class Connection
 * @package ByTIC\Queue\Connections
 */
class Connection
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var null|Producer
     */
    protected $producer = null;

    protected $destination = null;

    /**
     * Connection constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->build();
    }

    /**
     * @param Destination $destination
     */
    public function setDestination(Destination $destination): void
    {
        $this->destination = $destination;
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
        $destination = $destination ?: $this->destination;
//        $message = MessageTransform::transform($message, $this->context);
        $this->producer->send($destination, $message);
    }

    /**
     * @param string $name
     * @return \Interop\Queue\Queue
     */
    public function createDestinationQueue($name)
    {
        return $this->context->createQueue($name);
    }

    protected function build()
    {
        $this->producer = $this->context->createProducer();
    }
}