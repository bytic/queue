<?php

use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\JobQueue\Bus\PendingDispatch;
use Nip\Container\Container;

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

/**
 * @param \Interop\Queue\Destination $destination
 * @return string
 */
function queueDestinationName(\Interop\Queue\Destination $destination)
{
    if ($destination instanceof \Interop\Queue\Queue) {
        return $destination->getQueueName();
    }

    if ($destination instanceof \Interop\Queue\Topic) {
        return $destination->getTopicName();
    }

    return sha1(serialize($destination));
}

if (!function_exists('queue')) {
    /**
     * @param string $connection
     * @return Connection
     */
    function queue($connection)
    {
        if (function_exists('app')) {
            return app('queue')->connection($connection);
        }

        return Container::getInstance()->get('queue')->connection($connection);
    }
}