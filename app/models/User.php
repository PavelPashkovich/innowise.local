<?php

namespace app\models;

class User extends Model
{
//    protected static array $fillable = ['name', 'email', 'gender', 'status'];

    public string $name;
    public string $email;
    public string $gender;
    public string $status;

    public function __construct($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->gender = $data['gender'];
        $this->status = $data['status'];
    }
}
