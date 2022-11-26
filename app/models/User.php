<?php

namespace app\models;

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

}
