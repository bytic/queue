<?php

namespace ByTIC\Queue\Consumption;

use Enqueue\Client\DelegateProcessor;
use Interop\Queue\Context;
use Interop\Queue\Message as InteropMessage;
use Nip\Utility\Str;

/**
 * Class DelegatePreProcessor
 * @package ByTIC\Queue\Consumption
 */
class DelegatePreProcessor extends DelegateProcessor
{
    /**
     * {@inheritdoc}
     */
    public function process(InteropMessage $message, Context $context)
    {
        $message = $this->convertMessage($message, $context);
        return parent::process($message, $context);
    }

    public function convertMessage(InteropMessage $inMessage, Context $context): InteropMessage
    {
        $body = $inMessage->getBody();

        if (!Str::isJson($body)) {
            return $inMessage;
        }
        $data = json_decode($body, true);

        if (!isset($data['TopicArn']) || !isset($data['Type']) || 'Notification' !== $data['Type']) {
            return $inMessage;
        }

        $message = $context->createMessage();
        $message->setRedelivered($inMessage->isRedelivered());

        // SNS message conversion
        if (isset($data['Message'])) {
            $message->setBody((string)$data['Message']);
        }

        if (isset($data['MessageAttributes']['Headers'])) {
            $headersData = json_decode($data['MessageAttributes']['Headers']['Value'], true);

            if (is_array($headersData) && count($headersData) == 2) {
                $message->setHeaders($headersData[0]);
                $message->setProperties($headersData[1]);
            }
        }

        return $message;
    }
}
