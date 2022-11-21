<?php

namespace app\controllers;

use system\View;

class UserController
{
    public function new(): void
    {
        View::render('users/new');
    }

    public function create(): void
    {
        View::render('users/create', ['data' => 'Some data']);
    }
}
