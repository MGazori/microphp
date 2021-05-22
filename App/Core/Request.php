<?php

namespace App\Core;

class Request
{
    private $params;
    private $method;
    private $agent;
    private $ip;
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->params = $_REQUEST;
    }
    public function __get($name)
    {
        if (property_exists(self::class, $name))
            return $this->{$name};
        if (key_exists($name, $this->params))
            return $this->params[$name];
        return null;
    }
}
