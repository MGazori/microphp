<?php

use App\Core\Routing\Route;

Route::add(['get', 'post'], '/', 'HomeController@index');

Route::add(['get', 'post'], '/home', ['HomeController', 'index']);
