<?php

namespace App\Routing;

use Exception;

class Router
{
    protected $routes = [];

    public function add(string $method, string $path, string $controllerName, string $action)
    {
        return $this->routes[] = array("method" => $method, "path" => $path, "controller" => $controllerName, "action" => $action);
    }

    public function dispatch()
    {
        $id = null;
        $route = $this->findRoute();
        $path = $route['path'];
        $controller = $route['controller'];
        $action = $route['action'];

        if (preg_match("/[\d]+/", $path, $matches)) {
            $digitsFromPath = (int)implode(" ", $matches);
            //$tableColumns['id'] = $id;
            $id = $digitsFromPath;
        }

        $controller = new $controller;
        return $controller->$action($id);
    }

    public function findRoute()
    {
        $requestURI = trim(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL), "/");

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {

            //In case there is an ID
            if (preg_match("/[\d]+/", $requestURI)) {
                $str = preg_replace("/[\d]+/", '{$0}', $requestURI); //people/show/9
                $route['method'] = $requestMethod;
                $route['path'] = $str;
                preg_match("/^[a-zA-Z]+\/([a-zA-Z]+)\/[\d]+$/", $requestURI, $matches);
                $action = $matches[1];
                $route['action'] = $action;
                echo " there is an id, so this is the new route";
                print_r($route);
                return $route;
            }

            if ($route['method'] === $requestMethod && $route['path'] === $requestURI) {
                return $route;
            }
        }

        throw new Exception('Route not found', 404);
    }
}
