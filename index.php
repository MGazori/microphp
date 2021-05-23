<?php

// Front Controller
include 'bootstrap/init.php';

use App\Core\Routing\Router;


$routers = new Router();
$routers->run();
