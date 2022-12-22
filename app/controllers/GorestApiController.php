<?php

namespace app\controllers;

class GorestApiController extends Controller
{
    public function index()
    {
        $this->render('swagger.twig');
    }

    public function showSwagger()
    {
//        require("../../vendor/autoload.php");
        $openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'] . '/../app/controllers']);
        header('Content-Type: application/json');
        echo $openapi->toJson();
    }
}