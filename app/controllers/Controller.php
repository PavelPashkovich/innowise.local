<?php

namespace app\controllers;

use system\View;

class Controller
{
    /**
     * @param $path
     * @param array $data
     * @return void
     */
    protected function render($path, array $data = []): void
    {
        View::render($path, $data);
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