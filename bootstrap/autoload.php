<?php

spl_autoload_register(function (string $className) {
    require_once __DIR__ . '/../' . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
});
