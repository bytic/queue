<?php

namespace ByTIC\Queue\Tests\Connections\Traits;

use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\Messages\Message;
use ByTIC\Queue\Tests\AbstractTest;
use Enqueue\Null\NullConnectionFactory;
use Enqueue\Null\NullMessage;
use Enqueue\Null\NullProducer;
use Enqueue\Null\NullQueue;
use Mockery as m;

/**
 * Class ConnectionSendTraitTest
 * @package ByTIC\Queue\Tests\Connections\Traits
 */
class ConnectionSendTraitTest extends AbstractTest
{
    public function test_send_with_destination_null()
    {
        $connectionFactory = new NullConnectionFactory();
        $context = $connectionFactory->createContext();
        $connection = new Connection($context);
        $connection->setDefaultQueue('foe');

        $producer = m::mock(NullProducer::class);
        $producer->shouldReceive('send')->andReturnUsing(function ($destination, $message) {
            static::assertInstanceOf(NullMessage::class, $message);
            static::assertInstanceOf(NullQueue::class, $destination);
            static::assertSame('foe', $destination->getQueueName());
        });

        $connection->setProducer($producer);

        /** @noinspection PhpUnhandledExceptionInspection */
        $connection->send(new Message());
        static::addToAssertionCount(1);
    }
}