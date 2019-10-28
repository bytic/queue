<?php

namespace ByTIC\Queue\JobQueue\Bus;

use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\JobQueue\Jobs\Job;
use Interop\Queue\Exception;
use Interop\Queue\Exception\InvalidDestinationException;
use Interop\Queue\Exception\InvalidMessageException;
use Interop\Queue\Queue;
use Nip\Container\Container;

/**
 * Class Dispatcher
 * @package ByTIC\Queue\JobQueue\Bus
 */
class Dispatcher
{
    /**
     * @param Job $job
     * @throws Exception
     * @throws InvalidDestinationException
     * @throws InvalidMessageException
     */
    public static function dispatch($job)
    {
        $connection = static::getConnection($job->connection);
        $destination = static::determineDestination($connection, $job);
        $connection->send($job->createMessage(), $destination);
    }

    /**
     * @param Connection $connection
     * @param Job $job
     * @return null|Queue
     */
    protected static function determineDestination($connection, $job)
    {
        if ($job->queue) {
            return $connection->createDestinationQueue($job->queue);
        }
        return null;
    }

    /**
     * @param null|string $connection
     * @return Connection
     */
    protected static function getConnection($connection = null)
    {
        if (function_exists('app')) {
            return app('queue')->connection($connection);
        }

        return Container::getInstance()->get('queue')->connection($connection);
    }
}
