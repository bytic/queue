<?php

namespace ByTIC\Queue\JobQueue\Jobs\Traits;

/**
 * Trait HasArguments
 * @package ByTIC\Queue\JobQueue\Jobs\Traits
 */
trait HasArguments
{
    /**
     * @var array
     */
    protected $arguments;

    /**
     * @param $arguments
     */
    public function arguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}