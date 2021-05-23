<?php

define('BASEPATH', realpath(__DIR__ . '/../'));
require BASEPATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();

$request = new App\Core\Request();

include BASEPATH . '/helpers/helpers.php';
include BASEPATH . '/routes/web.php';
