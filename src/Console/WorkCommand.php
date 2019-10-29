<?php

namespace ByTIC\Queue\Console;

use ByTIC\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WorkCommand
 * @package ByTIC\Queue\Console
 */
class WorkCommand extends Command
{

    protected function configure()
    {
        parent::configure();
        $this->setName('queue:work');
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @return int|null null or 0 if everything went fine, or an error code
     *
     * @throws LogicException When this abstract method is not implemented
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
