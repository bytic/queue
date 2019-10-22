<?php

use ByTIC\Queue\JobQueue\Bus\PendingDispatch;

if (! function_exists('dispatch')) {
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param  mixed  $job
     * @return PendingDispatch
     */
    function dispatch($job)
    {
//        if ($job instanceof Closure) {
//            $job = new CallQueuedClosure(new SerializableClosure($job));
//        }
        return new PendingDispatch($job);
    }
}