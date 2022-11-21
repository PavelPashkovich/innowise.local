<?php

return [
    '/' => [\app\controllers\AppController::class, 'index'],
    '/users/new' => [\app\controllers\UserController::class, 'new'],
    '/users/create' => [\app\controllers\UserController::class, 'create'],
];
