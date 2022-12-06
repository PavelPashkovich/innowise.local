<?php

namespace system;

class Router
{
    private array $routes;
    private string $url;
    private string $method;
    private mixed $controller;
    private string $action;
    private ?int $id;
    private array $params;

    public function __construct($routes)
    {
        $this->routes = $routes;
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? '';
        $this->params = $this->getParams($query);
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if ($this->existUrl()) {
            $controller = new $this->controller;
            $action = $this->action;
            if (!empty($this->id)) {
                $controller->$action($this->id);
            } elseif (!empty($this->params)) {
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

    /**
     * @return bool
     */
    private function existUrl(): bool
    {
        $url = trim($this->url, '/');

        foreach($this->routes as $route){
            $route['url'] = rtrim($route['url'], "/");
            $regExp = "#^{$route['url']}$#";

            if (preg_match($regExp, $url, $matches) && $route['method'] == $this->method) {
                $this->controller = $route['controller'];
                $this->action = $route['action'];
                $this->id = array_slice($matches,1)[0] ?? null;
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $query
     * @return array
     */
    private function getParams(string $query = ''): array
    {
        $pattern = '#[?&]*(\w+)=(\w+)#';
        preg_match_all($pattern, $query, $res);
        $queryKeys = $res[1];
        $queryValues = $res[2];
        return array_combine($queryKeys, $queryValues);
    }

}