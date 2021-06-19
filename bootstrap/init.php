<?php

define('BASEPATH', realpath(__DIR__ . '/../'));
require BASEPATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();
include BASEPATH . '/helpers/helpers.php';

$request = new App\Core\Request();

include BASEPATH . '/routes/web.php';
