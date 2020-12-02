<?php

namespace ByTIC\Queue\Tests\Messages;

use ByTIC\Queue\Messages\Message;
use ByTIC\Queue\Messages\MessageTransform;
use ByTIC\Queue\Tests\AbstractTest;
use Enqueue\Sqs\SqsMessage;

/**
 * Class MessageTransformTest
 * @package ByTIC\Queue\Tests\Messages
 */
class MessageTransformTest extends AbstractTest
{
    public function test_transform_sqs_fifo()
    {
        $message = new Message();
        $factory = (new \Enqueue\ConnectionFactoryFactory())->create(['dsn' => 'sqs:']);
        $context = $factory->createContext();
        $destination = $context->createQueue('default.fifo');
        /** @var SqsMessage $messageInterop */
        $messageInterop = MessageTransform::transform($message, $context, $destination);

        self::assertInstanceOf(\Interop\Queue\Message::class, $messageInterop);

        self::assertGreaterThan(5, strlen($messageInterop->getMessageDeduplicationId()));
        self::assertGreaterThan(5, strlen($messageInterop->getMessageGroupId()));
    }
}
