<?php namespace MoodleSDK\Rest;

use MoodleSDK\Api\ApiCall;
use MoodleSDK\Log\ConsoleLog;

class RestApiCall implements ApiCall {

    private $debug;

    private $method;
    private $payload;
    private $responseType;
    private $url;

    public function __construct($url, $method, array $payload) {
        if (!function_exists('curl_init')) {
            throw new Exception('cURL module must be enabled');
        }

        $this->url = $url;
        $this->method = $method;
        $this->payload = $payload;
    }

    public function execute() {
        $curl = curl_init();
        $payloadQueryString = http_build_query($this->payload);

        if ($this->getDebug()) {
            ConsoleLog::i()
                ->section('cURL request: POST '.$this->url)
                ->info($this->url.'&wsfunction='.$this->method.'&'.$payloadQueryString);
        }
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->url.'&wsfunction='.$this->method.'&'.$payloadQueryString,
            CURLOPT_USERAGENT => 'agurz/moodle-php-sdk',
            CURLOPT_HTTPHEADER => [
                'Content-Type: text/plain',
            ],
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $payloadQueryString,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => false, // see http://unitstep.net/blog/2009/05/05/using-curl-in-php-to-access-https-ssltls-protected-sites/
            CURLOPT_CONNECTTIMEOUT => 30
        ]);

        $response = curl_exec($curl);

        $info = curl_getinfo($curl);
        $err = curl_error($curl);

        if ($this->getDebug()) {
            ConsoleLog::i()
                ->section('cURL response')
                ->info($response)
                ->infoAnx('INFO: '.json_encode($info))
                ->infoAnx('ERR: '.$err);
        }

        curl_close($curl);

        if ($err) {
            print_r($err);
            print_r($info);
        }

        return $response;
    }

    // Properties Getters & Setters

    public function getDebug() {
        return $this->debug;
    }

    public function setDebug($debug) {
        $this->debug = $debug;
        return $this;
    }

    public function getResponseType() {
        return $this->responseType;
    }

    public function setResponseType($responseType) {
        $this->responseType = $responseType;
        return $this;
    }

}