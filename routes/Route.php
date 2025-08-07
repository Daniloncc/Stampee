<?php

namespace App\Routes;

class Route
{
    private static $routes = [];

    public static function get($url, $controller)
    {
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'GET'];
    }

    public static function post($url, $controller)
    {
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'POST'];
    }

    public static function dispatch()
    {
        $url = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $urlSegments = explode('?', $url);
        $urlPath = $urlSegments[0];

        // print($url);
        // print($urlPath);
        // die;
        foreach (self::$routes as $route) {


            if (BASE . $route['url'] == $urlPath && $route['method'] == $method) {
                $contollerSegments = explode('@', $route['controller']);
                $controllerName = 'App\\Controllers\\' . $contollerSegments[0];
                $methodName = $contollerSegments[1];
                $controllerInstance = new $controllerName;

                if ($method == 'GET') {
                    if (isset($urlSegments[1])) {

                        parse_str($urlSegments[1], $queryParams);
                        // print($urlSegments[1]);
                        // print_r($queryParams);
                        // print($methodName);
                        // print($controllerName);
                        // die;
                        $controllerInstance->$methodName($queryParams);
                    } else {
                        $controllerInstance->$methodName();
                    }
                } elseif ($method == 'POST') {
                    if (isset($urlSegments[1])) {
                        parse_str($urlSegments[1], $queryParams);
                        $controllerInstance->$methodName($_POST, $queryParams);
                    } else {
                        $controllerInstance->$methodName($_POST);
                    }
                }
                return;
            }
        }
        $contollerSegments = explode('@', $route['controller']);
        $controllerName = 'App\\Controllers\\' . $contollerSegments[0];
        $methodName = "error";
        $controllerInstance = new $controllerName;
        $controllerInstance->$methodName();

        // http_response_code(404);
        // echo "404 page not found";
    }
}
