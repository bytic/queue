<?php

namespace ByTIC\Queue\JobQueue\Bus;

use ByTIC\Queue\JobQueue\Jobs\Job;

/**
 * Trait Dispatchable
 * @package ByTIC\Queue\JobQueue\Bus
 */
trait Dispatchable
{
    /**
     * Dispatch the job with the given arguments.
     *
     * @return PendingDispatch
     */
    public static function dispatch()
    {
        $arguments = func_get_args();
        $job = new Job(static::class);
        $job->arguments($arguments);

        return new PendingDispatch($job);
    }
}
