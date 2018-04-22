<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Request;


class Bot {

    protected $host = '';

    protected function send(string $method='', array $params=[], string $type="POST")
    {
        $uri = $this->host . $method;
        Log::info($uri);
        $params = ['form_params' => $params];

        $client = new Client();
        $result = $client->request($type, $uri, $params);

        return $result->getBody();
    }

    protected function sendToUri($uri, $params = [], $type="POST")
    {
        $params = ['form_params' => $params];

        $client = new Client();
        $result = $client->request($type, $uri, $params);

        return $result->getBody();
    }
}