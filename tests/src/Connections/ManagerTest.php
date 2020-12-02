<?php

namespace ByTIC\Queue\Tests\Connections;

use ByTIC\Queue\Connections\Manager;
use ByTIC\Queue\Tests\AbstractTest;

/**
 * Class ManagerTest
 * @package ByTIC\Queue\Tests\Connections
 */
class ManagerTest extends AbstractTest
{
    public function test_init()
    {
        $manager = new Manager();
        self::assertInstanceOf(Manager::class, $manager);
    }
}
