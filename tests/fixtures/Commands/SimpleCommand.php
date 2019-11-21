<?php

namespace ByTIC\Queue\Tests\Fixtures\Commands;

/**
 * Class SimpleCommand
 * @package ByTIC\Queue\Tests\Fixtures\Commands
 */
class SimpleCommand
{
    protected static $calls = [];

    public static function handle()
    {
        static::addCalls(func_get_args());
    }

    /**
     * @return array
     */
    public static function getCalls(): array
    {
        return self::$calls;
    }

    /**
     * @param array $arguments
     */
    public static function addCalls(array $arguments): void
    {
        self::$calls[] = $arguments;
    }

    /**
     * @param array $calls
     */
    public static function setCalls(array $calls): void
    {
        self::$calls = $calls;
    }
}
