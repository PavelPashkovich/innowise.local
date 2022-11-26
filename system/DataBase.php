<?php

namespace system;

use app\models\Model;
use PDO;
use PDOException;

class DataBase
{
    protected static ?PDO $connection = null;

    public static function getConnection(): ?PDO
    {
        if (!self::$connection) {
            try {
                self::$connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            } catch (\PDOException $exception) {
                echo "Connection error: " . $exception->getMessage();
            }
        }
        return self::$connection;
    }

    public static function all(Model $model)
    {
        if (self::getConnection() !== null) {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $sql = "SELECT * FROM " . $tableName;
            $result = $connection->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public static function find(Model $model, $id)
    {
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id;
            $result = $connection->query($sql);
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    public static function insert(Model $model, $data)
    {
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $columns = implode(', ', array_keys($data));
            $values = "'" . implode("' , '", array_values($data)) . "'";

            $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
            $connection->query($sql);

            $id = $connection->lastInsertId();

            return $id;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    public static function update(Model $model, $data)
    {
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
            return $data['id'];
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

    public static function delete(Model $model, $id)
    {
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $sql = "DELETE FROM $tableName WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }

//        echo "<pre>";
//        print_r($res);
//        echo "</pre>";
//        die();
//        }

}
