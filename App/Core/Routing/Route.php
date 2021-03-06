<?php

namespace App\Core\Routing;

class Route
{
    private static $routes = [];

    public static function add(array|string $method, string $uri, $action = null, array $middleware = [])
    {
        $methods = is_array($method) ? $method : [$method];
        self::$routes[] = [
            'methods' => $methods,
            'uri' => $uri,
            'action' => $action,
            'middleware' => $middleware
        ];
    }
    public static function __callStatic($name, $arguments)
    {
        $verbs = ['get', 'post', 'put', 'patch', 'delete', 'options'];
        if (!in_array($name, $verbs))
            throw new \Exception('Request method not support!');
        $uri = $arguments[0];
        $action = $arguments[1] ?? null;
        $middleware = $arguments[2] ?? [];
        self::add($name, $uri, $action, $middleware);
    }
    public static function routes()
    {
        return self::$routes;
    }
}
