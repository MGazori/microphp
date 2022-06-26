<?php

function site_url($route = ''): string
{
    return $_ENV['BASEURL'] . $route;
}

function asset_url($route): string
{
    return site_url('assets/' . $route);
}

function view($path, $data = [])
{
    extract($data);
    $path = str_replace('.', '/', $path);
    include_once BASEPATH . '/views/' . $path . '.php';
}

function view_die($path, $data = [])
{
    view($path, $data);
    die();
}

function xss_clean($str)
{
    return htmlspecialchars($str);
}