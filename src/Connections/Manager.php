<?php

namespace ByTIC\Queue\Connections;

use ByTIC\Queue\Connections\Manager\HasConfig;
use ByTIC\Queue\Connections\Manager\HasConnections;
use Nip\Container\ContainerAwareInterface;
use Nip\Container\ContainerAwareTrait;

/**
 * Class Manager
 * @package ByTIC\Queue\Connections
 */
class Manager implements ContainerAwareInterface
{
    use HasConnections;
    use HasConfig;
    use ContainerAwareTrait;
}
