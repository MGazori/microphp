<?php

define('BASEPATH', realpath(__DIR__ . '/../'));
require BASEPATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();
