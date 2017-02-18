<?php namespace MoodleSDK\Rest;

use MoodleSDK\Api\ApiContext;
use MoodleSDK\Auth\AuthTokenCredential;

class RestApiContext implements ApiContext {

    const RESPONSE_TYPE_ALLOWED = ['json']; // xml should be here on the future

    private $credential;
    private $hostname;
    private $responseType;
    private $secureConnection = true;

    public function __construct($hostname) {
        $this->setHostname($hostname);
        $this->setResponseType('json');
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
        return $scheme.'://'.$this->getHostname().'/webservice/rest/server.php?'.$responseTypeParam.'&'.$credentialParam;
    }

    // Properties Getters & Setters

    public function getCredential() {
        return $this->credential;
    }

    public function setCredential(AuthTokenCredential $credential) {
        $this->credential = $credential;
    }

    public function getHostname() {
        return $this->hostname;
    }

    public function setHostname($hostname) {
        $this->hostname = $hostname;
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