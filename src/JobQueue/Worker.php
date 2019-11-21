<?php

namespace ByTIC\Queue\JobQueue;

use ByTIC\Queue\JobQueue\Jobs\Job;
use Enqueue\Consumption\Result;
use Exception;
use Interop\Queue\Context;
use Interop\Queue\Message;
use Interop\Queue\Processor;

/**
 * Class Worker
 * @package ByTIC\Queue\JobQueue
 */
class Worker implements Processor
{
    /**
     * @inheritDoc
     */
    public function process(Message $message, Context $context)
    {
        $job = Job::fromMessage($message);
        return $this->runJob($job, $context);
    }

    /**
     * @param Job $job
     * @param Context $context
     * @return string
     */
    protected function runJob(Job $job, Context $context)
    {
        try {
            $job->fire();
        } catch (Exception $e) {
            // TODO Add logic to log exceptions
            return Result::REQUEUE;
        }

        return Result::ACK;
    }
}
