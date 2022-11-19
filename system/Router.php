<?php

namespace system;

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
    public static function run()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $routes = self::$routes;
        $runAction = [\app\controllers\AppController::class, 'notFound'];

        foreach ($routes as $route => $action) {
            if ($route == $uri) {
                $runAction = $action;
            }
        }

        $controller = new $runAction[0];
        $controller->{$runAction[1]}();
    }
}