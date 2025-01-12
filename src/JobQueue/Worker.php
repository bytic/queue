<?php

namespace ByTIC\Queue\JobQueue;

use ByTIC\Queue\JobQueue\Jobs\Job;
use Enqueue\Consumption\Result;
use Enqueue\Sqs\SqsMessage;
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
        return $this->runJob($job, $message, $context);
    }

    /**
     * @param Job $job
     * @param Context $context
     * @return string
     */
    protected function runJob(Job $job, Message $message, Context $context)
    {
        try {
            $job->fire();
        } catch (Exception $e) {
            return $this->onRunJobException($e, $job, $message, $context);
        }

        return Result::ACK;
    }

    /**
     * @param $exception
     * @param Job $job
     * @param Message $message
     * @param Exception $e
     * @return string
     */
    protected function onRunJobException($exception, Job $job, Message $message, Context $context)
    {
        if ($message instanceof SqsMessage) {
            $attributes = $message->getAttributes();
            $receiveCount = $attributes['ApproximateReceiveCount'] ?? 0;
            if ($receiveCount > 10) {
                return Result::REJECT;
            } elseif ($receiveCount > 1) {
                return Result::ALREADY_ACKNOWLEDGED;
            }
        }
        return Result::REQUEUE;
    }
}
