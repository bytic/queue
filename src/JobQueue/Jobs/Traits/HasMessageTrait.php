<?php

namespace ByTIC\Queue\JobQueue\Jobs\Traits;

use ByTIC\Queue\JobQueue\Jobs\Job;
use ByTIC\Queue\JobQueue\Worker;
use ByTIC\Queue\Messages\Message;
use Enqueue\Client\Config;
use Interop\Queue\Message as InteropMessage;

/**
 * Trait HasMessageTrait
 * @package ByTIC\Queue\JobQueue\Jobs\Traits
 */
trait HasMessageTrait
{
    /**
     * @param InteropMessage $message
     * @return HasMessageTrait|Job
     */
    public static function fromMessage(InteropMessage $message)
    {
        $payload = json_decode($message->getBody(), true);

        $callable = unserialize($payload['callable']);
        $job = new static($callable);

        $job->arguments(unserialize($payload['arguments']));
        return $job;
    }

    /**
     * @return Message
     */
    public function createMessage()
    {
        $message = new Message($this->createPayload());
        $message->setDelay($this->delay);
        $message->setProperty(
            Config::PROCESSOR,
            Worker::class
        );
        return $message;
    }

    /**
     * @return false|string
     */
    public function createPayload()
    {
        return json_encode([
            'callable' => serialize($this->callable),
            'arguments' => $this->createPayloadArguments()
        ]);
    }

    /**
     * @return string
     */
    protected function createPayloadArguments()
    {
        $arguments = [];
        foreach ($this->arguments as $key => $argument) {
            $arguments[$key] = $argument;
        }
        return serialize($arguments);
    }
}
