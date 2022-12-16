<?php

namespace system;

use PDO;
use PDOException;

class DataBase implements DataSourceActions
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
     * @param $data
     * @return array
     */
    public static function all($data): array
    {
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $data['table_name'];
            $perPage = $data['per_page'];
            $query = "SELECT count(*) FROM $tableName";
            $totalResults = $connection->query($query)->fetchColumn();
            $totalPages = ceil($totalResults / $perPage);
            $response['total_pages'] = $totalPages;

            $page = $data['page'] ?? 1;
            $response['page'] = $page;

            $offset = ($page - 1) * $perPage;
            $order = $params['order'] ?? 'id';
            $sql = "SELECT * FROM " . $tableName . " ORDER BY " . $order . " LIMIT " . $perPage . " OFFSET " . $offset;
            $response['success'] = $connection->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database_error'];
        }
        return $response;
    }

    /**
     * @param $data
     * @return array
     */
    public static function find($data): array
    {
        $messages = self::getMessages();
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $data['table_name'];
            $id = $data['id'];
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
     * @param $data
     * @return array
     */
    public static function insert($data): array
    {
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $data['table_name'];
            unset($data['table_name']);
            $columns = implode(', ', array_keys($data));
            $values = "'" . implode("' , '", array_values($data)) . "'";
            $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
            $connection->query($sql);
            $data['id'] = $connection->lastInsertId();
            $data['table_name'] = $tableName;
            $response = self::find($data);
        } catch (PDOException) {
            $messages = self::getMessages();
            $response['error'] = $messages['database_error'];
        }
        return $response;
    }

    /**
     * @param $data
     * @return array
     */
    public static function update($data): array
    {
        $messages = self::getMessages();
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $data['table_name'];
            unset($data['table_name']);
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
            $data['table_name'] = $tableName;
            $response = self::find($data);
        } catch (PDOException) {
            $response['error'] = $messages['database_error'];
        } catch (\Exception $exception) {
            $response['error'] = $exception->getMessage();
        }
        return $response;
    }

    /**
     * @param $data
     * @return array
     */
    public static function delete($data): array
    {
        $messages = self::getMessages();
        $response = [];
        try {
            $connection = self::getConnection();
            $tableName = $data['table_name'];
            $id = $data['id'];
            $itemExists = self::itemExists($connection, $tableName, 'id', $id);
            if (!$itemExists) {
                throw new \Exception(sprintf($messages['requested_id_#$id_was_not_found'], $id));
            }
            $sql = "DELETE FROM $tableName WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(":id", $id);
            $response['success'] = $stmt->execute(); // bool 'true'
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

