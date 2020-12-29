<?php

namespace ByTIC\Queue\JobQueue\Jobs\Traits;

use Nip\Utility\Arr;

/**
 * Trait Queueable
 * @package ByTIC\Queue\JobQueue\Bus
 */
trait Queueable
{
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */
    public $connection;

    /**
     * The name of the connection the chain should be sent to.
     *
     * @var string|null
     */
    public $chainConnection;

    /**
     * The number of seconds before the job should be made available.
     *
     * @var \DateTimeInterface|\DateInterval|int|null
     */
    public $delay;

    /**
     * The middleware the job should be dispatched through.
     */
    public $middleware = [];

    /**
     * The jobs that should run if this job is successful.
     *
     * @var array
     */
    public $chained = [];

    /**
     * Set the desired connection for the job.
     *
     * @param string|null $connection
     * @return $this
     */
    public function onConnection($connection)
    {
        $this->connection = $connection;
        return $this;
    }
    /**
     * Set the desired connection for the chain.
     *
     * @param string|null $connection
     * @return $this
     */
    public function allOnConnection($connection)
    {
        $this->chainConnection = $connection;
        $this->connection = $connection;
        return $this;
    }

    /**
     * Set the desired delay for the job.
     *
     * @param \DateTimeInterface|\DateInterval|int|null $delay
     * @return $this
     */
    public function delay($delay)
    {
        $this->delay = $delay;
        return $this;
    }

    /**
     * Specify the middleware the job should be dispatched through.
     *
     * @param array|object $middleware
     * @return $this
     */
    public function through($middleware)
    {
        $this->middleware = Arr::wrap($middleware);
        return $this;
    }

    /**
     * Set the jobs that should run if this job is successful.
     *
     * @param array $chain
     * @return $this
     */
    public function chain($chain)
    {
        $this->chained = collect($chain)->map(function ($job) {
            return serialize($job);
        })->all();
        return $this;
    }
}
