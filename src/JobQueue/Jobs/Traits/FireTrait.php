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
        $this->resolveCommand()($this->getArguments());
    }
}
