<?php

namespace app\models;

use system\DataBase;

class User extends Model
{
    protected static string $tableName = 'users';
    protected static array $columns = ['name', 'email', 'gender', 'status'];
    public string $name;
    public string $email;
    public string $gender;
    public string $status;

    public function __construct($data = [])
    {
        $this->name = $data['name'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->gender = $data['gender'] ?? '';
        $this->status = $data['status'] ?? '';
    }

    /**
     * @param $email
     * @return array
     */
    public function checkEmailExistence($email): array
    {
        $tableName = $this->getTableName();
        $sql = "SELECT COUNT(*) FROM " . $tableName . " WHERE email = '$email'";
        $response = DataBase::executeSqlQuery($sql);
        $result = [];
        if (isset($response['success'])) {
            $res = $response['success'];
            $result['success'] = $res->fetchColumn();
        } elseif (isset($response['error'])) {
            $result['error'] = $response['error'];
        }
        return $result;
    }

}
