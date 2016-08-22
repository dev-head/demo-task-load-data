<?php

namespace dapi\Client;

use dapi\Client;

/**
 * Class ClientFactory
 * @package dapi\Client
 */
final class ClientFactory
{
    /**
     * @var array
     */
    static protected $clients = [];

    /**
     * @param array $client_config
     * @return mixed
     */
    public static function getClient(array $client_config)
    {
        $client_name    = isset($client_config['name'])? $client_config['name'] : null;
        $client_name    = $client_name ?: isset($client_config['class'])? $client_config['class'] : null;

        if (isset(self::$clients[$client_name]) === false) {
            self::$clients[$client_name] = new Client($client_config);
        }
        return self::$clients[$client_name];
    }
}