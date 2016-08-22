<?php

namespace dapi;

use dapi\Client\ClientInterface;
use Doctrine\Common\Inflector\Inflector;

/**
 * Class Client
 * @package dapi
 */
final class Client implements ClientInterface
{
    /**
     * @var The true instantiated client object.
     */
    protected $client;

    /**
     * @var array The configuration data used to instantiate the client.
     */
    protected $client_config    = [];

    /**
     * Overload for the client directly from this class.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws \Exception
     */
    public function __call($name, $arguments)
    {
        $client = $this->getClient();

        if (!is_callable([$client, $name])) {
            throw new \BadMethodCallException('[ERROR]::[' . __METHOD__ .']::[unknown method]::[' . get_class($client) . '::' . $name . ']');
        }

        return call_user_func_array([$client, $name], $arguments);
    }

    /**
     * Client constructor.
     * @param array $client_config
     */
    public function __construct(array $client_config)
    {
        $class      = isset($client_config['class'])? $client_config['class'] : null;
        $config     = isset($client_config['config'])? $client_config['config'] : [];
        $client     = new $class($config);

        $this->setClientConfig($config);
        $this->setClient($client);

        /**
         * Auto-set the client properties based upon the config keys.
         */
        foreach ($config as $key => $val) {
            $method = 'set' . Inflector::classify($key);
            if (method_exists($client, $method)) {
                $this->$method($val);
            }
        }
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return array
     */
    public function getClientConfig(): array
    {
        return $this->client_config;
    }
    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function getClientConfigBy($key, $default = null)
    {
        return isset($this->client_config[$key])? $this->client_config[$key] : $default;
    }

    /**
     * Stub for interface.
     */
    public function search()
    {
        return $this->getClient()->search();
    }

    /**
     * @param mixed $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @param array $client_config
     */
    public function setClientConfig(array $client_config)
    {
        $this->client_config = $client_config;
    }
}