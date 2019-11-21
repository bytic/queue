<?php

namespace ByTIC\Queue\Connections\Traits;

use Interop\Queue\Destination;

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
    protected $defaultQueue = 'default';

    protected $destination = null;

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
}