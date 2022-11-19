<?php

// подключаем файл автозагрузки
require_once __DIR__ . '/../bootstrap/autoload.php';

(new \system\Router(require_once __DIR__ . '/../config/base-paths.php'))::run();
