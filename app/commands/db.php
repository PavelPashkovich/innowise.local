<?php

require_once __DIR__ . '/../../system/DataSourceActions.php';
require_once __DIR__ . '/../../system/DataBase.php';
require_once __DIR__ . '/../../database/Migration.php';
require_once __DIR__ . '/../../database/Seed.php';

use database\Migration;
use database\Seed;

switch ($argv[1]) {
    case 'migrate':
        Migration::migrate();
        break;
    case 'seed':
        Seed::seed();
        break;
}
