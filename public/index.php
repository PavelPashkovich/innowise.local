<?php

// подключаем файл автозагрузки и файл с роутами
require_once __DIR__ . '/../bootstrap/autoload.php';
//require_once __DIR__ . '/../config/base-config.php';
require_once __DIR__ . '/../config/gorest_api.php';
require_once __DIR__ . '/../vendor/autoload.php';
$routes = require_once __DIR__ . '/../config/base-paths.php';

(new \system\Router($routes))->run();
