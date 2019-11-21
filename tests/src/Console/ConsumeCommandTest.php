<?php

namespace ByTIC\Queue\Tests\Console;

use ByTIC\Console\Command;
use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\Console\ConsumeCommand;
use ByTIC\Queue\JobQueue\Jobs\Job;
use ByTIC\Queue\Tests\AbstractTest;
use ByTIC\Queue\Tests\Fixtures\Commands\SimpleCommand;
use Enqueue\Fs\FsConnectionFactory;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class ConsumeCommandTest
 * @package ByTIC\Queue\Tests\Console
 */
class ConsumeCommandTest extends AbstractTest
{
    public function test_should_be_sub_Class_of_command()
    {
        $command = new ConsumeCommand();
        static::assertInstanceOf(Command::class, $command);
    }

    public function test_should_have_command_name()
    {
        $command = new ConsumeCommand();
        static::assertEquals('queue:consume', $command->getName());
    }

    public function test_should_have_expected_options()
    {
        $command = new ConsumeCommand();
        $options = $command->getDefinition()->getOptions();

        static::assertCount(7, $options);

        static::assertArrayHasKey('connection', $options);
        static::assertArrayHasKey('memory-limit', $options);
        static::assertArrayHasKey('message-limit', $options);
        static::assertArrayHasKey('time-limit', $options);
        static::assertArrayHasKey('receive-timeout', $options);
        static::assertArrayHasKey('niceness', $options);
        static::assertArrayHasKey('logger', $options);
    }

    public function test_should_have_expected_attributes()
    {
        $command = new ConsumeCommand();
        $arguments = $command->getDefinition()->getArguments();

        static::assertCount(1, $arguments);
        static::assertArrayHasKey('queue-names', $arguments);
    }

    public function test_should_require_queue_names()
    {
        $command = \Mockery::mock(ConsumeCommand::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $command->__construct();
//        $command->shouldReceive('getConnection')->andReturn($connection);

        static::expectException(RuntimeException::class);
        static::expectExceptionMessage('Not enough arguments (missing: "queue-names")');

        $tester = new CommandTester($command);
        $tester->execute([]);
    }

    public function test_should_execute_default_consumption()
    {
        $connectionFactory = new FsConnectionFactory(['path' => TEST_FIXTURE_PATH . '/queue-fs']);
        $context = $connectionFactory->createContext();
        $eventQueue = $context->createQueue('event-queue');

        $connection = new Connection($context);

        $job = new Job([SimpleCommand::class, 'handle']);
        $job->arguments(['argument1', 'argument2']);
        $connection->send($job->createMessage(), $eventQueue);

        $command = \Mockery::mock(ConsumeCommand::class)->shouldAllowMockingProtectedMethods()->makePartial();
        $command->__construct();
        $command->shouldReceive('getConnection')->andReturn($connection);

        $tester = new CommandTester($command);
        $tester->execute(["queue-names" => "event-queue", "--message-limit" => 1]);

        $calls = SimpleCommand::getCalls();
        self::assertCount(1, $calls);
        self::assertSame(['argument1', 'argument2'], $calls[0]);
    }
}