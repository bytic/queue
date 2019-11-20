<?php

namespace ByTIC\Queue\Tests\Connections;

use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\Connections\ConnectionFactory;
use ByTIC\Queue\Messages\Message;
use Enqueue\Null\NullConnectionFactory;
use ByTIC\Queue\Tests\AbstractTest;
use Nip\Config\Config;
use Mockery as m;

/**
 * Class ConnectionTest
 * @package ByTIC\Queue\Tests\Connections
 */
class ConnectionTest extends AbstractTest
{
    public function testSend()
    {
        $connectionFactory = new NullConnectionFactory();
        $context = $connectionFactory->createContext();
        $fooTopic = $context->createTopic('aTopic');

        $connection = new Connection($context);
        $connection->send(new Message(), $fooTopic);
        static::addToAssertionCount(1);
    }
}
