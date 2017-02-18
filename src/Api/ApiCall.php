<?php namespace MoodleSDK\Api;

interface ApiCall {

    function __construct($url, $method, array $payload);
    function execute();

}