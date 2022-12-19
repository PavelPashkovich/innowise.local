<?php

namespace system;

//session_start();

use app\controllers\Controller;

class Router
{
    private array $routes;
    private string $url;
    private string $method;
    private mixed $controller;
    private string $action;
    private Request $request;

    public function __construct($routes)
    {
        $this->routes = $routes;
        $this->url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->request = new Request();
        $this->setRouterProperties();
        $this->setRequestProperties();
    }

    /**
     * @return void
     */
    public function run(): void
    {
        if ($this->controller) {
            $controller = $this->controller;
            $action = $this->action;
            $request = $this->request;
            $controller->$action($request);
        } else {
            $controller = new Controller();
            $controller->render('main/error.twig');
        }
    }

    private function setRouterProperties(): void
    {
        $url = trim($this->url, '/');

        foreach($this->routes as $route){
            $route['url'] = rtrim($route['url'], "/");
            $regExp = "#^{$route['url']}$#";

            if (preg_match($regExp, $url, $matches) && $route['method'] == $this->method) {
                $this->controller = new $route['controller'];
                $this->action = $route['action'];
                $id = array_slice($matches,1)[0] ?? null;
                $this->request->setId($id);
            }
        }
    }

    private function setRequestProperties(): void
    {
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY) ?? '';
        $params = $this->getParams($query);
        $this->request->setParams($params);
        $postData = $_POST ?? [];
        $this->request->setPostData($postData);
        $dataSources = require_once __DIR__ . '/../config/base-config.php';
        if ($_COOKIE['data_source'] && in_array($_COOKIE['data_source'], $dataSources)) {
            $dataSource = $_COOKIE['data_source'];
            $this->request->setDataSource($dataSource);
        } else {
            $this->request->setDataSource(DEFAULT_DATA_SOURCE);
        }
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