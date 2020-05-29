<?php

namespace ByTIC\Queue\Tests\JobQueue\Jobs\Traits;

use ByTIC\Queue\JobQueue\Jobs\Job;
use ByTIC\Queue\Tests\AbstractTest;
use ByTIC\Queue\Tests\Fixtures\Commands\SimpleCommand;
use ByTIC\Queue\Tests\Fixtures\Records\Books\Books;
use Nip\Database\Connections\Connection;

/**
 * Class HasMessageTraitTest
 * @package ByTIC\Queue\Tests\JobQueue\Jobs\Traits
 */
class HasMessageTraitTest extends AbstractTest
{
    public function test_create_payload_with_record()
    {
        $job = new Job([SimpleCommand::class, 'handle']);
        $books = Books::instance();
        $books->setDB(new Connection(false));

        $book = $books->getNew();
        $job->argument($book);

        $payload = $job->createPayload();
        self::assertJson($payload);
        self::assertLessThan(300, strlen($payload));
    }
}
