<?php

namespace app\controllers;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AppController extends Controller
{

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function index()
    {
        echo $this->view->render('main/index.twig');
    }


//    public function index(): void
//    {
//        $this->render('/main/index');
//    }
}
