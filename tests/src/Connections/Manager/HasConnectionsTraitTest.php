<?php

namespace ByTIC\Queue\Tests\Connections\Manager;

use ByTIC\Queue\Connections\Manager;
use ByTIC\Queue\Tests\AbstractTest;
use Mockery as m;

/**
 * Class HasConnectionsTraitTest
 * @package ByTIC\Queue\Tests\Connections\Manager
 */
class HasConnectionsTraitTest extends AbstractTest
{
    public function test_connection_default_driver_on_null()
    {
        /** @var Manager $manager */
        $manager = m::mock(Manager::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $manager->shouldReceive('getDefaultDriver')->andReturn('default_name');
        $manager->shouldReceive('resolve')->with('default_name')->andReturn('connection');

        self::assertSame('connection', $manager->connection());
    }
}