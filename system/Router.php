<?php

namespace system;

use app\controllers\AppController;

class Router
{
    private static array $routes;

    public function __construct($routes)
    {
        self::$routes = $routes;
    }

    /**
     * @return void
     */
    public function run(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $routes = self::$routes;

        if (isset($routes[$uri]) && !empty($routes[$uri])) {
            $controllerAndAction = $routes[$uri];
            $controllerName = $controllerAndAction[0];
            $actionName = $controllerAndAction[1];

            $controller = new $controllerName;
            $controller->$actionName();
        } else {
            View::render('main/notFound');
        }
    }
}