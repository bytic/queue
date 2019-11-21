<?php

namespace ByTIC\Queue\Connections\Traits;

use Interop\Queue\Consumer;
use Interop\Queue\Destination;

/**
 * Trait HasConsumerTrait
 * @package ByTIC\Queue\Connections\Traits
 */
trait HasConsumerTrait
{
    /**
     * @var Consumer[]
     */
    protected $consumers = [];

    /**
     * @param Destination|null $destination
     * @return Consumer|null
     */
    public function getConsumer(Destination $destination = null): ?Consumer
    {
        $destination = $destination ?: $this->createDestinationQueue();
        $destinationName = queueDestinationName($destination);
        if (!isset($this->consumers[$destinationName])) {
            $this->initConsumer($destinationName, $destination);
        }
        return $this->consumers[$destinationName];
    }

    /**
     * @param Consumer|null $consumer
     */
    public function setConsumer(?Consumer $consumer): void
    {
        $this->consumers = $consumer;
    }

    /**
     * @param string $destinationName
     * @param Destination $destination
     */
    protected function initConsumer(string $destinationName, Destination $destination)
    {
        $this->consumers[$destinationName] = $this->context->createConsumer($destination);
    }
}