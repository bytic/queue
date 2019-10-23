<?php

namespace ByTIC\Queue\Tests\Connections;

use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\Connections\ConnectionFactory;
use ByTIC\Queue\Tests\AbstractTest;
use Nip\Config\Config;

/**
 * Class ConnectionFactoryTest
 * @package ByTIC\Queue\Tests\Connections
 */
class ConnectionFactoryTest extends AbstractTest
{

    public function testBuild()
    {
        $configArray = require PROJECT_BASE_PATH . '/config/queue.php';
        $config = new Config($configArray['connections']['sqs']);
        $connection = ConnectionFactory::build($config->toArray());

        self::assertInstanceOf(Connection::class, $connection);
    }
}