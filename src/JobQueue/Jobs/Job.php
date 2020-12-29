<?php

namespace ByTIC\Queue\JobQueue\Jobs;

use ByTIC\Queue\JobQueue\Jobs\Traits\FireTrait;
use ByTIC\Queue\JobQueue\Jobs\Traits\HasArguments;
use ByTIC\Queue\JobQueue\Jobs\Traits\HasCommand;
use ByTIC\Queue\JobQueue\Jobs\Traits\HasDestination;
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
    use HasCommand;
    use HasDestination;
    use HasMessageTrait;
    use FireTrait;

    /**
     * Job constructor.
     * @param callable $command
     */
    public function __construct(callable $command)
    {
        $this->command = $command;
    }
}
