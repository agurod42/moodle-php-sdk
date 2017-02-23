<?php namespace MoodleSDK\Rest;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Auth\AuthTokenCredential;

class RestApiContext implements ApiContext {

    const RESPONSE_TYPE_ALLOWED = ['json']; // xml should be here on the future

    private $credential;
    private $hostname;
    private $port;
    private $protocol = 'tcp';
    private $responseType;
    private $secureConnection = true;

    public function __construct($hostname) {
        $this->setHostname($hostname);
        $this->setResponseType('json');

        if (!$this->isApiAvailable()) {
            throw new \Exception('API is unavailable. Cannot connect to '.$this->getHostname(true));
        }
    }

    public function isApiAvailable() {
        $errno = 0;
        $errstr = '';
        $socket = fsockopen($this->protocol.'://'.$this->getHostname(), $this->getPort(), $errno, $errstr);
        return !!$socket;
    }

    public function newCall($method, $payload) {
        $call = new RestApiCall($this->getUrl(), $method, $payload);
        $call->setResponseType($this->getResponseType());
        return $call;
    }

    public function getUrl() {
        $scheme = $this->getSecureConnection() ? 'https' : 'http';
        $credentialParam = $this->credential->toQueryStringParam();
        $responseTypeParam = 'moodlewsrestformat='.$this->getResponseType();
        return $scheme.'://'.$this->getHostname(true).'/webservice/rest/server.php?'.$responseTypeParam.'&'.$credentialParam;
    }

    // Properties Getters & Setters

    public function getCredential() {
        return $this->credential;
    }

    public function setCredential(AuthTokenCredential $credential) {
        $this->credential = $credential;
    }

    public function getHostname($includePort = false) {
        $hostname = $this->hostname;

        if ($includePort) {
            $hostname .= ':'.$this->getPort();
        }

        return $hostname;
    }

    public function setHostname($hostname) {
        $hostnameComponents = explode($hostname);

        if (count() > 1) {
            $this->setPort((int)$hostnameComponents[1]);
        }

        $this->hostname = $hostnameComponents[0];
    }

    public function getPort() {
        return $this->port ?: ($this->getSecureConnection() ? 443 : 80);
    }

    public function setPort($port) {
        $this->port = $port;
    }

    public function getResponseType() {
        return $this->responseType;
    }

    public function setResponseType($responseType) {
        if (!in_array($responseType, self::RESPONSE_TYPE_ALLOWED)) {
            throw new Exception('Invalid $responseType value. Supported values are: '.implode(', ', self::RESPONSE_TYPE_ALLOWED));
        }

        $this->responseType = $responseType;
    }
 
    public function getSecureConnection() {
        return $this->secureConnection;
    }

    public function setSecureConnection($secureConnection) {
        $this->secureConnection = $secureConnection;
    }
}