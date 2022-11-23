<?php

namespace system;

use app\controllers\AppController;

class Router
{
    private array $routes;
    private string $url;
    private string $method;
    private array $params;
    private mixed $controller;
    private string $action;

    public function __construct($routes)
    {
        $this->routes = $routes;
        $this->url = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }


    public function run(): void
    {
        if ($this->existUrl()) {
            $controller = new $this->controller;
            $action = $this->action;
            if (!empty($this->params)) {
                $controller->$action($this->params);
            } else {
                if (!empty($_POST)) {
                    $controller->$action($_POST);
                } else {
                    $controller->$action();
                }
            }
        } else {
            View::render('main/notFound');
        }

    }

    private function existUrl()
    {
        $url = trim($this->url, '/?');

        foreach($this->routes as $route){
            $route['url'] = rtrim($route['url'], "/");
            $regExp = "#^{$route['url']}$#";

            if (preg_match($regExp, $url, $matches) && $route['method'] == $this->method){
                $this->controller = $route['controller'];
                $this->action = $route['action'];
                $this->params = array_slice($matches,1);
                return true;
            }
        }
        return false;
    }



    /**
     * @return void
     */
//    public function run(): void
//    {
//        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//        $routes = self::$routes;
//
//        if (isset($routes[$uri]) && !empty($routes[$uri])) {
//            $controllerAndAction = $routes[$uri];
//            $controllerName = $controllerAndAction[0];
//            $actionName = $controllerAndAction[1];
//
//            $controller = new $controllerName;
//            $controller->$actionName();
//        } else {
//            View::render('main/notFound');
//        }
//    }
}