<?php

namespace ByTIC\Queue\Tests\JobQueue\Jobs;

use ArgumentCountError;
use ByTIC\Queue\JobQueue\Jobs\Job;
use ByTIC\Queue\Tests\AbstractTest;

/**
 * Class JobTest
 * @package ByTIC\Queue\Tests\JobQueue\Jobs
 */
class JobTest extends AbstractTest
{
    public function test_callable_parameter_required()
    {
        static::expectException(ArgumentCountError::class);
        $job = new Job();
    }
}
