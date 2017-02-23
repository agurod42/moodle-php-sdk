<?php namespace MoodleSDK\Rest;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Auth\AuthTokenCredential;

class RestApiContext implements ApiContext {

    const RESPONSE_TYPE_ALLOWED = ['json']; // xml should be here on the future

    private $debug = false;

    private $credential;
    private $host;
    private $path;
    private $port;
    private $protocol = 'tcp';
    private $responseType;

    public function __construct() {
        $this->setResponseType('json');
    }

    public function newCall($method, $payload) {
        $call = new RestApiCall($this->getWebServiceUrl(), $method, $payload);

        $call
            ->setDebug($this->getDebug())
            ->setResponseType($this->getResponseType());

        return $call;
    }

    private function getWebServiceUrl() {
        $scheme = $this->getSecureConnection() ? 'https' : 'http';
        $credentialParam = $this->credential->toQueryStringParam();
        $responseTypeParam = 'moodlewsrestformat='.$this->getResponseType();
        return $scheme.'://'.$this->getUrl().'/webservice/rest/server.php?'.$responseTypeParam.'&'.$credentialParam;
    }

    public function testApiAvailability() {
        $errno = 0;
        $errstr = '';

        $socket = fsockopen($this->protocol.'://'.$this->getHost(), $this->getPort(), $errno, $errstr);

        if (!$socket) {
            trigger_error('API is unavailable. Cannot connect to '.$this->getUrl(), E_USER_ERROR);
        }

        return true;
    }

    // Properties Getters & Setters

    public function getDebug() {
        return $this->debug;
    }

    public function setDebug($debug) {
        $this->debug = $debug;
        return $this;
    }

    public function getCredential() {
        return $this->credential;
    }

    public function setCredential($credential) {
        $this->credential = $credential;
        return $this;
    }

    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
        return $this;
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    public function getPort() {
        return $this->port;
    }

    public function setPort($port) {
        $this->port = $port;
        return $this;
    }

    public function getUrl() {
        $url = $this->getHost();
        $url .= ':'.$this->getPort();
        $url .= $this->getPath();
        return $url;
    }

    public function setUrl($url) {
        $components = parse_url($url);

        $this->setHost($components['host'] ?: $components['path']);
        $this->setPath($components['path'] ?: '');
        $this->setPort((int)$components['port'] ?: 0);

        if (!$this->getPort()) {
            $scheme = $components['scheme'] ?: 'http';
            $port = $scheme === 'https' ? 443 : 80;
            $this->setPort($port);
        }

        return $this;
    }

    public function getResponseType() {
        return $this->responseType;
    }

    public function setResponseType($responseType) {
        if (!in_array($responseType, self::RESPONSE_TYPE_ALLOWED)) {
            throw new Exception('Invalid $responseType value. Supported values are: '.implode(', ', self::RESPONSE_TYPE_ALLOWED));
        }

        $this->responseType = $responseType;

        return $this;
    }

}