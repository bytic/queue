<?php

namespace ByTIC\Queue\JobQueue\Jobs;

/**
 * Class Job
 * @package ByTIC\Queue\JobQueue\Jobs
 */
class Job
{
    /**
     * @var callable
     */
    protected $callable;

    /**
     * Job constructor.
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function createMessage()
    {

    }
}
