<?php

// подключаем файл автозагрузки
require_once __DIR__ . '/../bootstrap/autoload.php';
$routes = require_once __DIR__ . '/../config/base-paths.php';

(new \system\Router($routes))->run();
