<?php

namespace ByTIC\Queue\JobQueue\Jobs\Traits;

/**
 * Trait HasCommand
 * @package ByTIC\Queue\JobQueue\Jobs\Traits
 */
trait HasCommand
{

    /**
     * @var callable
     */
    protected $command;

    /**
     * @return \Closure
     * @throws \Exception
     */
    protected function resolveCommand(): \Closure
    {
        if (is_callable($this->command)) {
            return $this->resolveCommandCallable();
        }
        throw new \Exception('Invalid handler for queue Job');
    }

    protected function resolveCommandCallable(): \Closure
    {
        return function ($arguments) {
            return call_user_func_array($this->command, $arguments);
        };
    }
}
