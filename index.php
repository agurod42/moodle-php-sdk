<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'vendor/autoload.php';

use \MoodleSDK\Auth\AuthTokenCredential;
use \MoodleSDK\Api\Model\User;
use \MoodleSDK\Rest\RestApiContext;

$context = new RestApiContext('uycls185');
$context->setCredential(new AuthTokenCredential('34c6dbe3adb6e86efb05a39692ec77d8'));
$context->setSecureConnection(false);

$user = new User();
$userList = $user->all($context);

var_dump($userList[0]);