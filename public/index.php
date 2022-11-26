<?php

// подключаем файл автозагрузки
require_once __DIR__ . '/../bootstrap/autoload.php';
require_once __DIR__ . '/../config/database.php';
$routes = require_once __DIR__ . '/../config/base-paths.php';

(new \system\Router($routes))->run();
