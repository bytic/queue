<?php

namespace ByTIC\Queue\Messages;

use Enqueue\Sqs\SqsDestination;
use Enqueue\Sqs\SqsMessage;
use Interop\Queue\Context;
use Interop\Queue\Destination;
use Interop\Queue\Message as InteropMessage;
use Nip\Utility\Str;

/**
 * Class MessageTransform
 * @package ByTIC\Queue\Messages
 */
class MessageTransform
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * @var Context
     */
    protected $context;

    /**
     * @var Context
     */
    protected $destination;

    /**
     * @var InteropMessage
     */
    protected $contextMessage;

    /**
     * MessageTransform constructor.
     * @param Message|InteropMessage $message
     * @param Context $context
     */
    public function __construct(Message $message, Context $context, Destination $destination = null)
    {
        $this->message = $message;
        $this->context = $context;
        $this->destination = $destination;
        $this->contextMessage = $context->createMessage();
        $this->doTransformation();
    }

    /**
     * @param Message|InteropMessage $message
     * @param Context $context
     * @param Destination $destination
     * @return InteropMessage
     */
    public static function transform($message, $context, $destination = null)
    {
        $transformer = new static($message, $context, $destination);
        return $transformer->getContextMessage();
    }

    /**
     * @return InteropMessage
     */
    public function getContextMessage(): InteropMessage
    {
        return $this->contextMessage;
    }

    protected function doTransformation()
    {
        $this->transformBody();
        $this->transformProperties();
        $this->transformHeaders();
        $this->transformSpecialData();
    }

    protected function transformBody()
    {
        $this->contextMessage->setBody($this->message->getBody());
    }

    protected function transformProperties()
    {
        $this->contextMessage->setProperties($this->message->getProperties());
    }

    protected function transformHeaders()
    {
        $this->contextMessage->setHeaders($this->message->getHeaders());
    }

    protected function transformSpecialData()
    {
        if ($this->contextMessage instanceof SqsMessage) {
            $this->transformSpecialDataSqs();
            return;
        }
    }
    protected function transformSpecialDataSqs()
    {
        if (Str::endsWith( $this->destination->getQueueName(), '.fifo')) {
            $this->contextMessage->setMessageGroupId($this->message->getProperty('MessageGroupId', uniqid()));
            $this->contextMessage->setMessageDeduplicationId($this->message->getProperty('MessageDeduplicationId', uniqid()));
        }
    }
}