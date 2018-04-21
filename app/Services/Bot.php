<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7\Request;


class Bot {

    protected $host = '';

    public function send(string $method='', array $params=[], string $type="POST")
    {
        $uri = $this->host . $method;
        $params = ['form_params' => $params];
        Log::info($params);
        $client = new Client();
        $result = $client->request($type, $uri, $params);

        return $result->getBody();
    }
}