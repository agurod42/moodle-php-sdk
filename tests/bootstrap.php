<?php

require_once __DIR__.'/../vendor/autoload.php';

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if (file_exists(__DIR__.'/../.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__.'/..');
    $dotenv->load();
}