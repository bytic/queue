<?php

namespace ByTIC\Queue\JobQueue\Jobs;

use ByTIC\Queue\JobQueue\Jobs\Traits\FireTrait;
use ByTIC\Queue\JobQueue\Jobs\Traits\HasArguments;
use ByTIC\Queue\JobQueue\Jobs\Traits\HasMessageTrait;
use ByTIC\Queue\JobQueue\Jobs\Traits\Queueable;

/**
 * Class Job
 * @package ByTIC\Queue\JobQueue\Jobs
 */
class Job
{
    use Queueable;
    use HasArguments;
    use HasMessageTrait;
    use FireTrait;

    /**
     * @var callable
     */
    protected $callable;

    /**
     * Job constructor.
     * @param callable $callable
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }
}
