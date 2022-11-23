<?php

namespace app\controllers;

use app\models\User;
use system\DataBase;
use system\View;

class UserController
{
    public function index(): void
    {
        $tableName = User::getTableName();
        $users = DataBase::all($tableName);
        View::render('users/index', ['users' => $users]);
    }

    public function create(): void
    {
        View::render('users/create');
    }

    public function store($data): void
    {
        $user = new User($data);
        $savedId = DataBase::insert($user, $data);
        if ($savedId) {
            header("Location: users/$savedId");
        } else {
            View::render('main/notFound');
        }

//        View::render('users/create', ['data' => 'Some data']);
    }

    public function show($params): void
    {
        $tableName = User::getTableName();
        $id = $params[0];
        $user = DataBase::find($tableName, $id);
        View::render('users/show', ['user' => $user]);
    }

    //    public function getAllUsers()
//    {
//        $users = User::all();
//        echo "<pre>";
//        print_r($users);
//        echo "</pre>";
//    }
}
