<?php

namespace app\controllers;

class AppController extends Controller
{
    public function index(): void
    {
        $this->render('/main/index');
    }
}
