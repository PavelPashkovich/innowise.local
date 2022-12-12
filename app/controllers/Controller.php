<?php

namespace app\controllers;

use system\View;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class Controller
{

    public Environment $view;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../views');
        $this->view = new Environment($loader);
    }

    protected function render($view, array $data = []): void
    {
        try {
            echo $this->view->render($view, $data);
        } catch (LoaderError|RuntimeError|SyntaxError $e) {
            View::render('main/notFound', ['error' => $e->getMessage()]);
        }
    }


    /**
     * @param $url
     * @return void
     */
    protected function redirect($url): void
    {
        header("Location: $url");
    }
}