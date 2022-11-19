<?php

namespace app\controllers;

use system\View;

class UserController
{
    public function new()
    {
        View::render('users/new');
    }

    public function create()
    {
        View::render('users/create', ['data' => 'Some data']);
    }
}