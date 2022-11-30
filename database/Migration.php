<?php

namespace database;

//require_once __DIR__ . '/../system/DataBase.php';

use system\DataBase;

class Migration
{
    public static function migrate()
    {
        try {
            $connection = DataBase::getConnection();
            $sql = "CREATE TABLE IF NOT EXISTS users (
                id int(10) unsigned NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL DEFAULT '',
                email varchar(255) NOT NULL DEFAULT '',
                gender varchar(255) NOT NULL DEFAULT '',
                status varchar(255) NOT NULL DEFAULT '',
                PRIMARY KEY (id)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            $connection->query($sql);
        } catch (\PDOException $exception) {
            echo "Database error: " . $exception->getMessage();
        }
    }
}