<?php

namespace ByTIC\Queue\JobQueue\Jobs;

use ByTIC\Queue\JobQueue\Jobs\Traits\Queueable;
use ByTIC\Queue\Messages\Message;

/**
 * Class Job
 * @package ByTIC\Queue\JobQueue\Jobs
 */
class Job
{
    use Queueable;

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

    /**
     * @return Message
     */
    public function createMessage()
    {
        $message = new Message();
        $message->setProperty('callable', serialize($this->callable));
        return $message;
    }
}
