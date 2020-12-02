<?php

namespace ByTIC\Queue\Tests;

use PHPUnit\Framework\TestCase;
use Mockery as m;

/**
 * Class AbstractTest
 */
abstract class AbstractTest extends TestCase
{
    public function tearDown(): void
    {
        parent::tearDown();
        m::close();
    }
}
