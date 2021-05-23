<?php

use App\Core\Routing\Route;

Route::add(['get', 'post'], '/', 'HomeController@index');

Route::add(['get', 'post'], '/home', ['HomeController', 'index']);

Route::add(['get', 'post'], '/a', function () {
    echo 'this is test callable get|post a function';
});

Route::post('/b', function () {
    echo 'this is test callable post b function';
});

Route::put('/c', function () {
    echo 'this is test callable put c function';
});
