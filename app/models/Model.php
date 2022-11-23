<?php

namespace app\models;

use PDO;
use system\DataBase;

abstract class Model
{
//    protected static array $fillable;
    protected static string $tableName;

//    public function __construct()
//    {
//        self::$tableName = $this->getTableName();
//    }

    public static function getTableName(): string
    {
        if (empty(static::$tableName)) {
            $className = static::class;
            $className = explode('\\', $className);
            $className = array_pop($className);
            $className = strtolower($className);
            $tableName = $className . "s";
        } else {
            $tableName = static::$tableName;
        }
        return $tableName;
    }
}



