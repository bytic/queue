<?php

namespace ByTIC\Queue\Connections\Traits;

use Interop\Queue\Destination;
use Interop\Queue\Queue;
use Interop\Queue\Topic;

/**
 * Trait HasDestinationsTrait
 * @package ByTIC\Queue\Connections\Traits
 */
trait HasDestinationsTrait
{
    /**
     * The name of the default queue.
     *
     * @var string
     */
    protected $defaultDestinationName = 'default';

    protected $destination = null;

    /**
     * @param Destination $destination
     */
    public function setDestination(Destination $destination): void
    {
        $this->destination = $destination;
    }

    /**
     * @param string|null $name
     * @param string|null $type
     * @return \Interop\Queue\Destination
     */
    public function createDestination($name = null, $type = null): \Interop\Queue\Destination
    {
        $name = $name ?: $this->defaultDestinationName;
        if ($type == \ByTIC\Queue\Destinations\Destination::TOPIC) {
            return $this->createDestinationTopic($name);
        }
        return $this->createDestinationQueue($name);
    }

    /**
     * @param string $name
     * @return Queue
     */
    public function createDestinationQueue($name = null): Queue
    {
        $name = $name ?: $this->defaultDestinationName;
        return $this->context->createQueue($name);
    }

    /**
     * @param string $name
     * @return Topic
     */
    public function createDestinationTopic($name = null): Topic
    {
        $name = $name ?: $this->defaultDestinationName;
        return $this->context->createTopic($name);
    }
}
