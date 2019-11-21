<?php

namespace ByTIC\Queue\Tests;

use PHPUnit\Framework\TestCase;
use \Mockery as m;

/**
 * Class AbstractTest
 */
abstract class AbstractTest extends TestCase
{
    protected $object;

    public function tearDown()
    {
        parent::tearDown();
        m::close();
    }
}
