<?php

namespace app\controllers;

use system\View;

class AppController
{
    public function index()
    {
        View::render('main/index');
    }

    public function notFound()
    {
        View::render('main/notFound');
    }
}