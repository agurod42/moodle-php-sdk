<?php namespace MoodleSDK\Auth;

class AuthTokenCredential implements Credential {

    private $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function toQueryStringParam() {
        return 'wstoken='.$this->token;
    }

}