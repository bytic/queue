<?php

namespace ByTIC\Queue\Messages;

use Interop\Queue\Context;
use Interop\Queue\Message as InteropMessage;

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
     * @var InteropMessage
     */
    protected $contextMessage;

    /**
     * MessageTransform constructor.
     * @param Message|InteropMessage $message
     * @param Context $context
     */
    public function __construct(Message $message, Context $context)
    {
        $this->message = $message;
        $this->context = $context;
        $this->contextMessage = $context->createMessage();
        $this->doTransformation();
    }

    /**
     * @param Message|InteropMessage $message
     * @param Context $context
     * @return InteropMessage
     */
    public static function transform($message, $context)
    {
        $transformer = new static($message, $context);
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
}