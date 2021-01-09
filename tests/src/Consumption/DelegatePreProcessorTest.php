<?php

namespace ByTIC\Queue\Tests\Consumption;

use ByTIC\Queue\Consumption\DelegatePreProcessor;
use ByTIC\Queue\Tests\AbstractTest;
use Enqueue\ArrayProcessorRegistry;
use Enqueue\Client\Config;
use Enqueue\Sqs\SqsContext;
use Enqueue\Sqs\SqsMessage;

/**
 * Class DelegatePreProcessorTest
 * @package ByTIC\Queue\Tests\Consumption
 */
class DelegatePreProcessorTest extends AbstractTest
{
    public function test_convertMessage()
    {
        $message = new SqsMessage();
        $message->setBody('{
  "Type" : "Notification",
  "MessageId" : "de0e0754",
  "TopicArn" : "arn:aws:sns:eu-central-1",
  "Message" : "",
  "Timestamp" : "2021-01-09T16:48:55.859Z",
  "MessageAttributes" : {
    "Headers" : {"Type":"String","Value":"[[],{\"enqueue.processor\":\"ByTIC\"}]"}
  }
 }');

        $processorRegistry = new ArrayProcessorRegistry([]);
        $processor = new DelegatePreProcessor($processorRegistry);

        $context = \Mockery::mock(SqsContext::class)->makePartial();
        $context->shouldReceive('createMessage')->andReturn(new SqsMessage());

        $outMessage = $processor->convertMessage($message, $context);

        self::assertInstanceOf(SqsMessage::class, $outMessage);
        self::assertSame('ByTIC', $outMessage->getProperty(Config::PROCESSOR));
    }
}