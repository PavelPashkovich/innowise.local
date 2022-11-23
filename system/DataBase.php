<?php

namespace system;

use app\models\Model;
use PDO;

class DataBase
{
//    private static string $host;
//    private static string $db_name;
//    private static string $user_name;
//    private static string $password;
//    protected static array $fillable = [];
//    protected static string $tableName;
    protected static ?PDO $connection = null;
//
//    public function __construct()
//    {
//        $database = require_once __DIR__ . '/../config/database.php';
//        self::$host = $database['host'];
//        self::$db_name = $database['db_name'];
//        self::$user_name = $database['user_name'];
//        self::$password = $database['password'];
//    }

    public static function getConnection(): ?PDO
    {
        if (!self::$connection) {
            $database = require_once __DIR__ . '/../config/database.php';
            $host = $database['host'];
            $db_name = $database['db_name'];
            $user_name = $database['user_name'];
            $password = $database['password'];
            try {
                self::$connection = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $user_name, $password);
            } catch (\PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
        }
        return self::$connection;
    }

    public static function all($tableName)
    {
        if (self::getConnection() !== null) {
            $connection = self::getConnection();
            $sql = "SELECT * FROM " . $tableName;
            $result = $connection->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function find($tableName, $id)
    {
        if (self::getConnection() !== null) {
            $connection = self::getConnection();
            $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id;
            $result = $connection->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        }
    }

    public static function insert(Model $model, $data)
    {
        if (self::getConnection() !== null) {
            $connection = self::getConnection();
            $tableName = $model::getTableName();
            $columns = implode(', ', array_keys($data));
            $values = "'" . implode("' , '", array_values($data)) . "'";

            $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
            $connection->query($sql);

            $id = $connection->lastInsertId();

            return $id;
        }
    }

}
