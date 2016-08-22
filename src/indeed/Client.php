<?php

namespace indeed;

use GuzzleHttp\Client as VendorClient;

/**
 * Class Client
 * @todo    Place this into it's own repo.
 * @package indeed
 */
class Client extends VendorClient
{
    /**
     * @var string
     */
    protected $endpoint = 'http://api.indeed.com/ads/apisearch';

    /**
     * @var array
     */
    protected $default_request_params   = [];

    /**
     * @var array
     */
    protected $searches = [];

    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $config['base_uri'] = isset($config['base_uri'])? $config['base_uri'] : $this->getEndpoint();
        parent::__construct($config);
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @param string $endpoint
     */
    public function setEndpoint(string $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return array
     */
    public function getDefaultRequestParams(): array
    {
        return $this->default_request_params;
    }

    /**
     * @param array $default_request_params
     */
    public function setDefaultRequestParams(array $default_request_params)
    {
        $this->default_request_params = $default_request_params;
    }

    /**
     * @return array
     */
    public function getSearches(): array
    {
        return $this->searches;
    }

    /**
     * @param array $searches
     */
    public function setSearches(array $searches)
    {
        $this->searches = $searches;
    }

    /**
     * @return array
     */
    public function search(): array
    {
        $return     = [];
        $searches   = $this->getSearches();
        $defaults   = $this->getDefaultRequestParams();
        $format     = isset($defaults['format'])? $defaults['format'] : 'json';
        $uri        = $this->getEndpoint();

        for ($i = 0; $i < $c = count($searches); $i++) {
            $query      = array_merge($defaults, $searches[$i]);
            $response   = $this->request('GET', $uri, ['query' => $query]);
            $this->validateResponse($response);
            $data   = $this->parseResponse($format, $response->getBody());
            $return = array_merge($return, $data);  // @todo: this is overly expensive, rethink.
        }

        return $return;
    }

    /**
     * @param $response
     * @return bool
     */
    protected function validateResponse($response): bool
    {
        $return = false;
        $code = $response->getStatusCode();

        if ($code >= 200 && $code < 210) {
            $return = true;
        }

        if ($return === false) {
            throw new \RuntimeException('[ERROR]::[' . __METHOD__ .']::[invalid response code]::[' . $code . ']');
        }

        return $return;
    }

    /**
     * @param string $format
     * @param $response
     * @return array
     */
    protected function parseResponse($format = 'json', $response): array
    {
        $return = [];

        switch ($format) {
            case 'json':
                $return = \GuzzleHttp\json_decode($response, true);
                $return = isset($return['results'])? $return['results'] : [];
                break;
            default:
                throw new \RuntimeException('[ERROR]::[' . __METHOD__ .']::[unsupported response format]::[' . $format . ']');
                break;
        }

        return $return;
    }
}