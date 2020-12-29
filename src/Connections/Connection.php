<?php

namespace ByTIC\Queue\Connections;

use ByTIC\Queue\Connections\Traits\ConnectionSendTrait;
use ByTIC\Queue\Connections\Traits\HasConsumerTrait;
use ByTIC\Queue\Connections\Traits\HasDestinationsTrait;
use Interop\Queue\Context;
use Interop\Queue\Producer;

/**
 * Class Connection
 * @package ByTIC\Queue\Connections
 */
class Connection
{
    use ConnectionSendTrait;
    use HasDestinationsTrait;
    use HasConsumerTrait;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var null|Producer
     */
    protected $producer = null;

    /**
     * Connection constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
        $this->build();
    }

    protected function build()
    {
        $this->setProducer($this->context->createProducer());
    }

    /**
     * @param string $defaultQueue
     */
    public function setDefaultQueue(string $defaultQueue): void
    {
        $this->defaultDestinationName = $defaultQueue;
    }

    /**
     * @return Producer|null
     */
    public function getProducer(): ?Producer
    {
        return $this->producer;
    }

    /**
     * @param Producer|null $producer
     */
    public function setProducer($producer): void
    {
        $this->producer = $producer;
    }

    /**
     * @return Context
     */
    public function getContext(): Context
    {
        return $this->context;
    }
}
