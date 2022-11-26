<?php

namespace app\controllers;

use app\models\User;
use app\requests\RequestUserStore;

class UserController extends Controller
{
    public function index(): void
    {
        $users = (new User)->all();
        $this->render('/users/index', ['users' => $users]);
    }

    public function create(): void
    {
        $this->render('/users/create');
    }

    public function store($data): void
    {
        $errors = (new RequestUserStore())->validate($data);
        if (!empty($errors)) {
            $this->render('users/create', ['errors' => $errors]);
        } else {
            $savedId = (new User())->insert($data);
            $this->redirect("/users/$savedId");
        }
    }

    public function show($id): void
    {
        $user = (new User())->find($id);
        $this->render('/users/show', ['user' => $user]);
    }

    public function edit($id): void
    {
        $user = (new User())->find($id);
        $this->render('/users/edit', ['user' => $user]);
    }

    public function update($data): void
    {
        $updatedId = (new User)->update($data);
        $this->redirect("/users/$updatedId");
    }

    public function destroy($id): void
    {
        (new User())->delete($id);
        $this->redirect("/users");
    }


}

//echo "<pre>";
//print_r($errors);
//echo "</pre>";
//die();
