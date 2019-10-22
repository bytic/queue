<?php

namespace ByTIC\Queue\JobQueue\Bus;

use ByTIC\Queue\Connections\Connection;
use Nip\Container\Container;

/**
 * Class Dispatcher
 * @package ByTIC\Queue\JobQueue\Bus
 */
class Dispatcher
{
    /**
     * @param $job
     */
    public static function dispatch($job)
    {
        $connection = static::getConnection();
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