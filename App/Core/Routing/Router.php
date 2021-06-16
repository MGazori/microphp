<?php

namespace App\Core\Routing;

use App\Core\Request;
use App\Core\Routing\Route;

class Router
{
    private $request;
    private $routes;
    private $current_route;
    private const BASE_CONTROLLER_NAME_SPACE = 'App\Controllers\\';
    public function __construct()
    {
        $this->request = new Request();
        $this->routes = Route::routes();
        $this->current_route = $this->findRoute($this->request) ?? null;
        # run middleware
        if (isset($this->current_route['middleware']) && !empty($this->current_route['middleware']))
            $this->runMiddleware();
    }
    private function runMiddleware()
    {
        foreach ($this->current_route['middleware'] as $middleware_class) {
            $middle_ware_obj = new $middleware_class;
            $middle_ware_obj->handle();
        }
    }
    public function findRoute(Request $request)
    {
        foreach ($this->routes as $route) {
            if (!in_array($request->method, $route['methods']))
                continue;
            if ($this->regexMatched($route['uri']))
                return $route;
        }
        return null;
    }
    private function regexMatched($uri)
    {
        global $request;
        $pattern = '/^' . str_replace(['/', '{', '}'], ['\/', '(?<', '>[-%\w]+)'], $uri) . '$/';
        $result = preg_match($pattern, $this->request->uri, $matches);
        if (!$result)
            return false;
        foreach ($matches as $key => $value) {
            if (!is_int($key))
                $request->add_route_params($key, $value);
        }
        return true;
    }
    public function isInvalidRequestMethod(Request $request)
    {
        foreach ($this->routes as $route) {
            if ($request->uri == $route['uri'] && !in_array($request->method, $route['methods']))
                return true;
        }
        return false;
    }
    public function dispatch405()
    {
        header("HTTP/1.0 405 Method Not Allowed");
        view('errors.405');
        die();
    }
    public function dispatch404()
    {
        header("HTTP/1.0 404 Not Found");
        view('errors.404');
        die();
    }
    public function run()
    {
        #for 405
        if ($this->isInvalidRequestMethod($this->request))
            $this->dispatch405();
        #for 404
        if (is_null($this->current_route))
            $this->dispatch404();
        $this->dispatch($this->current_route);
    }
    private function dispatch($route)
    {
        $action = $route['action'];
        #for action null
        if (is_null($action) || empty($action))
            return;
        #for action closure
        if (is_callable($action))
            call_user_func($action);
        #for action string
        if (is_string($action))
            $action = explode('@', $action);
        #for action array
        if (is_array($action)) {
            $class_name = self::BASE_CONTROLLER_NAME_SPACE . $action[0] ?? null;
            $method_name = $action[1] ?? null;
            if (!class_exists($class_name))
                throw new \Exception("Class $class_name Not Found!");
            $controller = new $class_name();
            if (!method_exists($controller, $method_name) || is_null($method_name) || empty($method_name))
                throw new \Exception("Class $method_name Not Found!");
            $controller->{$method_name}();
        }
    }
}
