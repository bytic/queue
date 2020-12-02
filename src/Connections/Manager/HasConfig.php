<?php

namespace ByTIC\Queue\Connections\Manager;

/**
 * Trait HasConfig
 * @package ByTIC\Queue\Connections\Manager
 */
trait HasConfig
{
    /**
     * Get the queue configuration.
     *
     * @param string $name
     * @return array
     */
    protected function getConfig($name)
    {
        if (!is_null($name) && $name !== 'null') {
            $name = '.' . $name;
        }
        $name = 'queue' . $name;
        return config($name);
    }
}
