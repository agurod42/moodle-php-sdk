<?php

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$dotenv = new Dotenv\Dotenv(__DIR__.'/..');
$dotenv->load();