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
     * @var array
     */
    protected $arguments;


    /**
     * Job constructor.
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    /**
     * @param $arguments
     */
    public function arguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return Message
     */
    public function createMessage()
    {
        $body = [
            'callable' => serialize($this->callable),
            'arguments' => serialize($this->arguments)
        ];
        $message = new Message(json_encode($body));
        $message->setDelay($this->delay);
        return $message;
    }
}
