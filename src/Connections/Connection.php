<?php

namespace ByTIC\Queue\Connections;

use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Message;
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
    }

    /**
     * @param Message $message
     * @param Destination|null $destination
     * @throws \Interop\Queue\Exception
     * @throws \Interop\Queue\Exception\InvalidDestinationException
     * @throws \Interop\Queue\Exception\InvalidMessageException
     */
    public function send(Message $message, Destination $destination = null)
    {
        $destination = $destination ?: $this->destination;
        $this->producer->send($destination, $message);
    }

    protected function build()
    {
        $this->producer = $this->context->createProducer();
    }
}