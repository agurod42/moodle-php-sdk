<?php namespace MoodleSDK\Api;

interface ApiContext {

    function isApiAvailable();

    function newCall($method, $payload);

}