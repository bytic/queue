<?php

namespace ByTIC\Queue\Connections;

use Interop\Queue\Context;
use Nip\Config\Config;

/**
 * Class ConnectionFactory
 * @package ByTIC\Queue\Connections
 */
class ConnectionFactory
{
    /**
     * @param $config
     * @return Connection
     */
    public static function build($config)
    {
        $config = static::createConfiguration($config);
        $factory = (new \Enqueue\ConnectionFactoryFactory())->create($config);
        $context = $factory->createContext();

        return static::fromContext($context, $config);
    }

    /**
     * @param Context $context
     * @param array $config
     * @return Connection
     */
    public static function fromContext($context, $config)
    {
        $connection = new Connection($context);
        if (isset($config['queue'])) {
            $connection->setDefaultQueue($config['queue']);
        }
        return $connection;
    }

    /**
     * @param Config|array $configs
     * @return array
     */
    protected static function createConfiguration($configs)
    {
        $return = $configs  instanceof Config ? $configs->toArray() : $configs;

        $return['dsn'] = $return['driver'].':';

//        $configProcessor = new ConfigProcessor();
//        $simpleClientConfig = $configProcessor->process($configs);
//
//        if (isset($simpleClientConfig['transport']['factory_service'])) {
//            throw new \LogicException('transport.factory_service option is not supported by simple client');
//        }
//        if (isset($simpleClientConfig['transport']['factory_class'])) {
//            throw new \LogicException('transport.factory_class option is not supported by simple client');
//        }
//        if (isset($simpleClientConfig['transport']['connection_factory_class'])) {
//            throw new \LogicException('transport.connection_factory_class option is not supported by simple client');
//        }
//        return $simpleClientConfig;
        return $return;
    }
}