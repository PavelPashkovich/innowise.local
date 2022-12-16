<?php

namespace app\controllers;

use system\Request;

class DataSourceController extends Controller
{
    public function setDataSource(Request $request)
    {
        $params = $request->getParams();
        $dataSource = $params['data_source'];
        setcookie('data_source', $dataSource, time() + 60 * 60 * 24, '/');
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
}