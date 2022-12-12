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
        $db = require_once __DIR__ . '/../config/database.php';
        if (!self::$connection) {
            self::$connection = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['db_name'], $db['user_name'], $db['password']);
        }
        return self::$connection;
    }

    /**
     * @param Model $model
     * @param $params
     * @return array
     */
    public static function all(Model $model, $params): array
    {
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $limit_per_page = $params['limit_per_page'];
            $query = "SELECT count(*) FROM $tableName";
            $total_results = $connection->query($query)->fetchColumn();
            $total_pages = ceil($total_results / $limit_per_page);
            $response['total_pages'] = $total_pages;

            $page = $params['page'] ?? 1;
            $response['page'] = $page;

            $offset = ($page - 1) * $limit_per_page;
            $order = $params['order'] ?? 'id';
            $sql = "SELECT * FROM " . $tableName . " ORDER BY " . $order . " LIMIT " . $limit_per_page . " OFFSET " . $offset;
            $response['success'] = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database_error'];
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
        $messages = self::getMessages();
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $itemExists = self::itemExists($connection, $tableName, 'id', $id);
            if (!$itemExists) {
                throw new \Exception(sprintf($messages['requested_id_#$id_was_not_found'], $id));
            }
            $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id;
            $result = $connection->query($sql);
            $response['success'] = $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database_error'];
        } catch (\Exception $exception) {
            $response['error'] = $exception->getMessage();
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
            $response['error'] = $messages['database_error'];
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
        $messages = self::getMessages();
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $id = $data['id'];

            $itemExists = self::itemExists($connection, $tableName, 'id', $id);
            if (!$itemExists) {
                throw new \Exception(sprintf($messages['requested_id_#$id_was_not_found'], $id));
            }

            $values = [];
            foreach ($data as $key => $value) {
                if ($key == 'id') {
                    continue;
                }
                $values[] = $key . ' = ' . '"' . $value .'"';
            }
            $values = implode(', ', $values);

            $sql = "UPDATE $tableName SET $values WHERE id = $id";
            $connection->query($sql);
            $response['success'] = $id;
        } catch (PDOException) {
            $response['error'] = $messages['database_error'];
        } catch (\Exception $exception) {
            $response['error'] = $exception->getMessage();
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
        $messages = self::getMessages();
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $model->getTableName();
            $itemExists = self::itemExists($connection, $tableName, 'id', $id);
            if (!$itemExists) {
                throw new \Exception(sprintf($messages['requested_id_#$id_was_not_found'], $id));
            }
            $sql = "DELETE FROM $tableName WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            $response['success'] = $stmt->execute();
        } catch (PDOException) {
            $response['error'] = $messages['database_error'];
        } catch (\Exception $exception) {
            $response['error'] = $exception->getMessage();
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

    /**
     * @param $connection
     * @param $tableName
     * @param $column
     * @param $item
     * @return mixed
     */
    protected static function itemExists($connection, $tableName, $column, $item): mixed
    {
        $query = "SELECT count(*) FROM " . $tableName . " WHERE $column = " . $item;
        return $connection->query($query)->fetchColumn();
    }

}

