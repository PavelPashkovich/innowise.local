<?php

return [
    [
        'url' => '',
        'method' => 'GET',
        'controller' => \app\controllers\AppController::class,
        'action' => 'index'
    ],
    [
        'url' => 'users',
        'method' => 'GET',
        'controller' => \app\controllers\UserController::class,
        'action' => 'index'
    ],
    [
        'url' => 'users/create',
        'method' => 'GET',
        'controller' => \app\controllers\UserController::class,
        'action' => 'create'
    ],
    [
        'url' => 'users',
        'method' => 'POST',
        'controller' => \app\controllers\UserController::class,
        'action' => 'store'
    ],
    [
        'url' => 'users/([0-9]+)',
        'method' => 'GET',
        'controller' => \app\controllers\UserController::class,
        'action' => 'show'
    ],
    [
        'url' => 'users/edit/([0-9]+)',
        'method' => 'GET',
        'controller' => \app\controllers\UserController::class,
        'action' => 'edit'
    ],
    [
        'url' => 'users/update',
        'method' => 'POST',
        'controller' => \app\controllers\UserController::class,
        'action' => 'update'
    ],
    [
        'url' => 'users/([0-9]+)',
        'method' => 'POST',
        'controller' => \app\controllers\UserController::class,
        'action' => 'destroy'
    ],
    [
        'url' => 'users/deleteMultiple',
        'method' => 'POST',
        'controller' => \app\controllers\UserController::class,
        'action' => 'destroyMultiple'
    ],
    [
        'url' => 'data-source',
        'method' => 'GET',
        'controller' => \app\controllers\DataSourceController::class,
        'action' => 'setDataSource'
    ],
//    [
//        'url' => 'gorest-rest-api',
//        'method' => 'GET',
//        'controller' => \app\controllers\DataSourceController::class,
//        'action' => 'setDataSourceSource'
//    ],
];

//return [
//    '/' => [\app\controllers\AppController::class, 'index'],
//    '/users' => [\app\controllers\UserController::class, 'all'],
//    '/user/show' => [\app\controllers\UserController::class, 'one'],
//    '/users/new' => [\app\controllers\UserController::class, 'new'],
//    '/users/create' => [\app\controllers\UserController::class, 'create'],
//];
