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
        return new PendingDispatch(
            new Job(static::class)
        );
    }
}
