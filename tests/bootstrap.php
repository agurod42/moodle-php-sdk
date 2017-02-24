<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if (class_exists('Dotenv\Dotenv')) {
    $dotenv = new Dotenv\Dotenv(__DIR__.'/..');
    $dotenv->load();
}