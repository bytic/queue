<?php

namespace ByTIC\Queue\Connections;

use ByTIC\Queue\Connections\Traits\ConnectionSendTrait;
use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Producer;

/**
 * Class Connection
 * @package ByTIC\Queue\Connections
 */
class Connection
{
    use ConnectionSendTrait;

    /**
     * @var Context
     */
    protected $context;

    /**
     * The name of the default queue.
     *
     * @var string
     */
    protected $defaultQueue = 'default';

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
     * @param string $name
     * @return \Interop\Queue\Queue
     */
    public function createDestinationQueue($name = null)
    {
        $name = $name ?: $this->defaultQueue;
        return $this->context->createQueue($name);
    }

    protected function build()
    {
        $this->producer = $this->context->createProducer();
    }
}