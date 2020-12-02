<?php

namespace ByTIC\Queue;

use ByTIC\Queue\Console\ConsumeCommand;
use Nip\Container\ServiceProviders\Providers\AbstractSignatureServiceProvider;

/**
 * Class QueueServiceProvider
 * @package ByTIC\Queue
 */
class QueueServiceProvider extends AbstractSignatureServiceProvider
{
    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerManager();
        $this->registerConnection();
    }

    /**
     * Register the queue manager.
     *
     * @return void
     */
    protected function registerManager()
    {
        $this->getContainer()->share('queue', function () {
            $manager = new Connections\Manager();
            $manager->setContainer($this->getContainer());
            return $manager;
        });
    }

    /**
     * Register the default queue connection binding.
     *
     * @return void
     */
    protected function registerConnection()
    {
        $this->getContainer()->share('queue.connection', function () {
            return $this->getContainer()->get('queue')->connection();
        });
    }

    protected function registerCommands()
    {
        $this->commands(ConsumeCommand::class);
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['queue', 'queue.connection'];
    }
}
