<?php

namespace ByTIC\Queue\Destinations;

/**
 * Class Message
 * @package ByTIC\Queue\Destinations
 */
class Destination implements \Interop\Queue\Destination
{
    const TOPIC = 'topic';
    const QUEUE = 'queue';
}

