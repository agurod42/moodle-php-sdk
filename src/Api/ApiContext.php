<?php namespace MoodleSDK\Api;

interface ApiContext {

    function newCall($method, $payload);
    
    function testApiAvailability();

}