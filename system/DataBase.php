<?php

namespace system;

use app\models\Model;
use PDO;
use PDOException;

class DataBase
{
    protected static ?PDO $connection = null;
    protected static array $messages = [];

    public static function getMessages()
    {
        if (!self::$messages) {
            self::$messages = require_once __DIR__ . '/../config/messages.php';
        }
        return self::$messages;
    }

    public static function getConnection(): ?PDO
    {
        if (!self::$connection) {
            self::$connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        }
        return self::$connection;
    }

    /**
     * @param Model $model
     * @return array
     */
    public static function all(Model $model): array
    {
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $sql = "SELECT * FROM " . $tableName;
            $result = $connection->query($sql);
            $response['success'] = $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database error'];
        }
        return $response;
    }

    /**
     * @param Model $model
     * @param $id
     * @return array
     */
    public static function find(Model $model, $id): array
    {
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id;
            $result = $connection->query($sql);
            $response['success'] = $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database error'];
        }
        return $response;
    }

    /**
     * @param Model $model
     * @param $data
     * @return array
     */
    public static function insert(Model $model, $data): array
    {
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $columns = implode(', ', array_keys($data));
            $values = "'" . implode("' , '", array_values($data)) . "'";
            $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
            $connection->query($sql);
            $response['success'] = $connection->lastInsertId();
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database error'];
        }
        return $response;
    }

    /**
     * @param Model $model
     * @param $data
     * @return array
     */
    public static function update(Model $model, $data): array
    {
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();

            $values = [];
            foreach ($data as $key => $value) {
                if ($key == 'id') {
                    continue;
                }
                $values[] = $key . ' = ' . '"' . $value .'"';
            }
            $values = implode(', ', $values);

            $sql = "UPDATE $tableName SET $values WHERE id = {$data['id']}";
            $connection->query($sql);
            $response['success'] = $data['id'];
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database error'];
        }
        return $response;
    }

    /**
     * @param Model $model
     * @param $id
     * @return array
     */
    public static function delete(Model $model, $id): array
    {
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $sql = "DELETE FROM $tableName WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            $response['success'] = $stmt->execute();
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database error'];
        }
        return $response;
    }

    /**
     * @param $sql
     * @return array
     */
    public static function executeSqlQuery($sql): array
    {
        $response = [];
        try {
            $connection = DataBase::getConnection();
            $response['success'] = $connection->query($sql);
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database error'];
        }
        return $response;
    }

//        echo "<pre>";
//        print_r($res);
//        echo "</pre>";
//        die();
//        }

}
