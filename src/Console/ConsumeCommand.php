<?php

namespace ByTIC\Queue\Console;

use ByTIC\Console\Command;
use ByTIC\Queue\Connections\Connection;
use ByTIC\Queue\Consumption\DelegatePreProcessor;
use ByTIC\Queue\JobQueue\Worker;
use Enqueue\ArrayProcessorRegistry;
use Enqueue\Consumption\ChainExtension;
use Enqueue\Consumption\Extension\ExitStatusExtension;
use Enqueue\Consumption\ExtensionInterface;
use Enqueue\Consumption\QueueConsumer;
use Enqueue\Symfony\Consumption\ChooseLoggerCommandTrait;
use Enqueue\Symfony\Consumption\LimitsExtensionsCommandTrait;
use Enqueue\Symfony\Consumption\QueueConsumerOptionsCommandTrait;
use Exception;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsumeCommand
 * @package ByTIC\Queue\Console
 */
class ConsumeCommand extends Command
{
    use LimitsExtensionsCommandTrait;
    use QueueConsumerOptionsCommandTrait;
    use ChooseLoggerCommandTrait;

    protected function configure()
    {
        parent::configure();
        $this->setName('queue:consume');

        $this->configureQueueConsumerOptions();
        $this->configureLimitsExtensions();
        $this->configureLoggerExtension();

        $this
            ->setAliases(['q:c'])
            ->setDescription('A client\'s worker that processes messages. ' .
                'By default it connects to default queue. ' .
                'It select an appropriate message processor based on a message headers')
            ->addArgument(
                'queue-names',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'Queues to consume messages from'
            )
//            ->addOption('skip', null, InputOption::VALUE_IS_ARRAY |

            ->addOption(
                'connection',
                'c',
                InputOption::VALUE_OPTIONAL,
                'The connection to consume messages from.',
                null
            );
    }

    /**
     * @inheritDoc
     * @noinspection PhpMissingParentCallCommonInspection
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connection = $this->getConnection($input);

        $consumer = $this->getQueueConsumer($connection);
        $this->setQueueConsumerOptions($consumer, $input);

        $queues = $this->determineQueues($input);
        $processor = $this->getProcessor();

        foreach ($queues as $queue) {
            $queue = $connection->getContext()->createQueue($queue);
            $consumer->bind($queue, $processor);
        }

        $runtimeExtensionChain = $this->getRuntimeExtensions($input, $output);
        $exitStatusExtension = new ExitStatusExtension();

        $consumer->consume(new ChainExtension([$runtimeExtensionChain, $exitStatusExtension]));

        return $exitStatusExtension->getExitStatus() ?? 0;
    }

    /**
     * @param InputInterface $input
     * @return array
     */
    protected function determineQueues(InputInterface $input)
    {
        $queue = $input->getArgument('queue-names');
        return is_array($queue) ? $queue : [$queue];
    }

    /**
     * @param InputInterface $input
     * @return Connection
     */
    protected function getConnection(InputInterface $input)
    {
        $connectionName = $input->hasArgument('connection')
            ? $input->getArgument('connection')
            : null;
        return queue($connectionName);
    }

    /**
     * @return DelegatePreProcessor
     */
    protected function getProcessor(): DelegatePreProcessor
    {
        $processorRegistry = new ArrayProcessorRegistry([]);
        $processor = new DelegatePreProcessor($processorRegistry);

        $worker = new Worker();
        $processorRegistry->add(Worker::class, $worker);

        return $processor;
    }

    /**
     * @param Connection $connection
     * @return QueueConsumer
     */
    protected function getQueueConsumer($connection): QueueConsumer
    {
        return new QueueConsumer($connection->getContext());
    }


    protected function getRuntimeExtensions(InputInterface $input, OutputInterface $output): ExtensionInterface
    {
        $extensions = [];

        $extensions = array_merge($extensions, $this->getLimitsExtensions($input, $output));

        $loggerExtension = $this->getLoggerExtension($input, $output);
        if ($loggerExtension) {
            array_unshift($extensions, $loggerExtension);
        }

        return new ChainExtension($extensions);
    }
}
