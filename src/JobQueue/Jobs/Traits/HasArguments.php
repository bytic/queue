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
     * @param $value
     * @param null $key
     */
    public function argument($value, $key = null)
    {
        if ($key === null) {
            $this->arguments[] = $value;
            return;
        }
        $this->arguments[$key] = $value;
        return;
    }

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
