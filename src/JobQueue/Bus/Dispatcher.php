<?php

namespace ByTIC\Queue\JobQueue\Bus;

use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\JobQueue\Jobs\Job;
use Interop\Queue\Destination;
use Interop\Queue\Exception;
use Interop\Queue\Exception\InvalidDestinationException;
use Interop\Queue\Exception\InvalidMessageException;

/**
 * Class Dispatcher
 * @package ByTIC\Queue\JobQueue\Bus
 */
class Dispatcher
{
    /**
     * @param Job $job
     */
    public static function dispatch(Job $job)
    {
        $connection = static::getConnection($job->connection);
        $destination = static::determineDestination($connection, $job);
        $connection->send($job->createMessage(), $destination);
    }

    /**
     * @param Connection $connection
     * @param Job $job
     * @return null|Destination
     */
    protected static function determineDestination(Connection $connection, Job $job): ?Destination
    {
        if ($job->hasDestination()) {
            return $connection->createDestination($job->getDestinationName(), $job->getDestinationType());
        }
        return null;
    }

    /**
     * @param null|string $connection
     * @return Connection
     */
    protected static function getConnection($connection = null): Connection
    {
        return \queue($connection);
    }
}
