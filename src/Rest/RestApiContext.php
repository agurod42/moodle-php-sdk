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
    private $secureConnection = true;

    public function __construct($url) {
        $this->setUrl($url);
        $this->setResponseType('json');

        if (!$this->isApiAvailable()) {
            throw new \Exception('API is unavailable. Cannot connect to '.$this->getUrl());
        }
    }

    public function isApiAvailable() {
        $errno = 0;
        $errstr = '';
        $socket = fsockopen($this->protocol.'://'.$this->getHost(), $this->getPort(), $errno, $errstr);
        return !!$socket;
    }

    public function newCall($method, $payload) {
        $call = new RestApiCall($this->getWebServiceUrl(), $method, $payload);

        $call
            ->setDebug($this->getDebug())
            ->setResponseType($this->getResponseType());

        return $call;
    }

    public function getWebServiceUrl() {
        $scheme = $this->getSecureConnection() ? 'https' : 'http';
        $credentialParam = $this->credential->toQueryStringParam();
        $responseTypeParam = 'moodlewsrestformat='.$this->getResponseType();
        return $scheme.'://'.$this->getUrl().'/webservice/rest/server.php?'.$responseTypeParam.'&'.$credentialParam;
    }

    private function getUrl() {
        $url = $this->getHost();
        $url .= ':'.$this->getPort();
        $url .= $this->getPath();
        return $url;
    }

    private function setUrl($url) {
        $components = parse_url($url);

        $this->setHost($components['host']);
        $this->setPath($components['path']);
        $this->setPort((int)$components['port']);
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

    public function setCredential(AuthTokenCredential $credential) {
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
        return $this->port ?: ($this->getSecureConnection() ? 443 : 80);
    }

    public function setPort($port) {
        $this->port = $port;
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
 
    public function getSecureConnection() {
        return $this->secureConnection;
    }

    public function setSecureConnection($secureConnection) {
        $this->secureConnection = $secureConnection;
        return $this;
    }
}