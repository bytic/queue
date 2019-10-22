<?php

namespace ByTIC\Queue;

use Nip\Container\ServiceProvider\AbstractSignatureServiceProvider;

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
        $this->getContainer()->singleton('queue', function () {
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
        $this->getContainer()->singleton('queue.connection', function () {
            return $this->getContainer()->get('queue')->connection();
        });
    }

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return ['queue', 'queue.connection'];
    }
}
