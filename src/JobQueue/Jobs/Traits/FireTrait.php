<?php

namespace ByTIC\Queue\JobQueue\Jobs\Traits;

/**
 * Trait FireTrait
 * @package ByTIC\Queue\JobQueue\Jobs\Traits
 */
trait FireTrait
{
    public function fire(): void
    {
        call_user_func_array($this->callable, $this->getArguments());
    }
}