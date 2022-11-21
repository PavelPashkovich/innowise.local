<?php

namespace app\controllers;

use system\View;

class AppController
{
    public function index(): void
    {
        View::render('main/index');
    }
}
