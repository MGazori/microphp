<?php

namespace App\Core;

class Request
{
    private $params;
    private $route_params;
    private $method;
    private $agent;
    private $ip;
    private $uri;

    public function __construct()
    {
        foreach ($_REQUEST as $key => $value)
            $_REQUEST[$key] = xss_clean($value);
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->params = $_REQUEST;
        $this->uri = strtok($_SERVER['REQUEST_URI'], '?');
    }

    public function add_route_params($key, $value): void
    {
        $this->route_params[$key] = $value;
    }

    public function __get($name)
    {
        if (property_exists(self::class, $name))
            return $this->{$name};
        if (key_exists($name, $this->params))
            return $this->params[$name];
        if (!is_null($this->route_params) && key_exists($name, $this->route_params))
            return $this->route_params[$name];
        return null;
    }

    public function input($key)
    {
        return $this->params[$key] ?? null;
    }

    public function isset_params($key): bool
    {
        return isset($this->params[$key]);
    }
}
