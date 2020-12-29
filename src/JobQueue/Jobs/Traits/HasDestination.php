<?php

namespace ByTIC\Queue\JobQueue\Jobs\Traits;

use ByTIC\Queue\Destinations\Destination;

trait HasDestination
{

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    protected $destinationName;

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    protected $destinationType = Destination::QUEUE;

    /**
     * The name of the queue the chain should be sent to.
     *
     * @var string|null
     */
    public $chainQueue;

    /**
     * Set the desired queue for the job.
     *
     * @param string|null $queue
     * @return $this
     */
    public function onQueue($queue): self
    {
        return $this->onDestination($queue, Destination::QUEUE);
    }

    /**
     * Set the desired topic for the job.
     *
     * @param string|null $queue
     * @return $this
     */
    public function onTopic($queue): self
    {
        return $this->onDestination($queue, Destination::TOPIC);
    }

    /**
     * @param $name
     * @param string $type
     * @return $this
     */
    public function onDestination($name, $type = Destination::QUEUE): self
    {
        $this->destinationName = $name;
        $this->destinationType = $type;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDestinationName(): ?string
    {
        return $this->destinationName;
    }

    /**
     * @return string|null
     */
    public function getDestinationType(): ?string
    {
        return $this->destinationType;
    }

    public function hasDestination(): bool
    {
        return !empty($this->destinationName);
    }

    /**
     * Set the desired queue for the chain.
     *
     * @param string|null $queue
     * @return $this
     */
    public function allOnQueue($queue)
    {
        $this->chainQueue = $queue;
        $this->destinationName = $queue;
        return $this;
    }
}