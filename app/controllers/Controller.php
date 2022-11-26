<?php

namespace app\controllers;

use system\View;

class Controller
{
    protected function render($path, $data = []): void
    {
        View::render($path, $data);
    }

    protected function redirect($url): void
    {
        header("Location: $url");
    }
}