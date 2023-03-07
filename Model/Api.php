<?php

namespace Fay\Api\Model;

use Fay\Api\Helper\Config;
use Fay\Api\Logger\Logger;
use Magento\Framework\Serialize\Serializer\Json;

class Api
{
    protected Config $config;
    protected Logger $logger;
    protected Json $json;
    protected const API_HOST = 'https://api.faythefary.io';

    public function __construct(Config $config, Logger $logger, Json $json)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->json = $json;
    }

    public function callOrderCreate(array $data) : void
    {
        $this->sendRequest('/v1/orders', $data);
    }

    protected function sendRequest(string $endpoint, array $params, $method = null) : void
    {
        $this->logger->info('Call api model');
        //curl stuff here
        $url = $this->config->getApiEndpoint();
        $apiKey = $this->config->getApiKey();

        if (!$url || !$apiKey) {
            throw new \RuntimeException(__('No api credentials  found'));
        }

        $curl = curl_init();
        $encodedParams = $this->json->serialize($params);
        $this->logger->info($encodedParams);
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $encodedParams,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($encodedParams),
                'x-apikey: ' . $this->getApiKey()
            ],
        ]);

        // Submit the request
        $response = curl_exec($curl);
        $err = curl_errno($curl);
        $this->logger->info($err);
        if ($err) {
            throw new \RuntimeException(curl_error($curl));
        }

        curl_close($curl);
        $this->logger->info('Request finished');
        $this->logger->info(($response));
    }

    protected function getApiKey() : ?string
    {
        return $this->config->getApiKey();
    }
}
