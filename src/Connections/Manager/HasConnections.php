<?php

namespace ByTIC\Queue\Connections\Manager;

use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\Connections\ConnectionFactory;
use Nip\Config\Config;

/**
 * Trait HasConnections
 * @package ByTIC\Queue\Connections\Manager
 */
trait HasConnections
{
    /**
     * The array of resolved queue connections.
     *
     * @var Connection[]
     */
    protected $connections = [];

    /**
     * @param null|string $name
     * @return Connection
     */
    public function connection($name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        // If the connection has not been resolved yet we will resolve it now as all
        // of the connections are resolved when they are actually needed so we do
        // not make any unnecessary connection to the various queue end-points.
        if (!isset($this->connections[$name])) {
            $this->connections[$name] = $this->resolve($name);
        }
        return $this->connections[$name];
    }

    /**
     * Resolve a queue connection.
     *
     * @param string $name
     * @return Connection
     */
    protected function resolve($name)
    {
        return ConnectionFactory::build($this->getConnectionConfig($name));
    }

    /**
     * Get the queue connection configuration.
     *
     * @param string $name
     * @return Config
     */
    protected function getConnectionConfig($name)
    {
        if (!is_null($name) && $name !== 'null') {
            return $this->getConfig("connections.{$name}");
        }
        return ['driver' => 'null'];
    }

    /**
     * Get the name of the default queue connection.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->getConfig('default');
    }

    abstract protected function getConfig($name);
}
