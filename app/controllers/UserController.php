<?php

namespace app\controllers;

use app\models\User;
use app\requests\UserStoreRequest;

class UserController extends Controller
{
    public function index(): void
    {
        $response = (new User)->all();
        if (isset($response['success'])) {
            $users = $response['success'];
            $this->render('/users/index', ['users' => $users]);
        } elseif (isset($response['error'])) {
            $error = $response['error'];
            $this->render('/users/index', ['error' => $error]);
        }

    }

    public function create(): void
    {
        $this->render('/users/create');
    }

    public function store($data): void
    {
        $errors = (new UserStoreRequest())->validate($data);
        if (!empty($errors)) {
            $this->render('users/create', ['errors' => $errors]);
        } else {
            $response = (new User())->insert($data);
            if (isset($response['success'])) {
                $savedId = $response['success'];
                $this->redirect("/users/$savedId");
            } elseif (isset($response['error'])) {
                $error = $response['error'];
                $this->render('/users/create', ['error' => $error]);
            }
        }
    }

    public function show($id): void
    {
        $response = (new User())->find($id);
        if (isset($response['success'])) {
            $user = $response['success'];
            $this->render('/users/show', ['user' => $user]);
        } elseif (isset($response['error'])) {
            $error = $response['error'];
            $this->render('/users/show', ['error' => $error]);
        }


    }

    public function edit($id): void
    {
        $response = (new User())->find($id);
        if (isset($response['success'])) {
            $user = $response['success'];
            $this->render('/users/edit', ['user' => $user]);
        } elseif (isset($response['error'])) {
            $error = $response['error'];
            $this->render('/users/edit', ['error' => $error]);
        }
    }

    public function update($data): void
    {
        $response = (new User())->find($data['id']);
        if (isset($response['success'])) {
            $user = $response['success'];
            $errors = (new UserStoreRequest())->validate($data);
            if (!empty($errors)) {
                $this->render('users/edit', ['user' => $user, 'errors' => $errors]);
            } else {
                $res = (new User)->update($data);
                if (isset($res['success'])) {
                    $updatedId = $res['success'];
                    $this->redirect("/users/$updatedId");
                } elseif (isset($res['error'])) {
                    $error = $res['error'];
                    $this->render("/users/edit", ['error' => $error]);
                }
            }
        } elseif (isset($response['error'])) {
            $error = $response['error'];
            $this->render('users/edit', ['error' => $error]);
        }

//        $user = (new User())->find($data['id']);
//        $errors = (new UserStoreRequest())->validate($data);
//        if (!empty($errors)) {
//            $this->render('users/edit', ['user' => $user, 'errors' => $errors]);
//        } else {
//            $updatedId = (new User)->update($data);
//            $this->redirect("/users/$updatedId");
//        }
    }

    public function destroy($id): void
    {
        $response = (new User())->delete($id);
        if (isset($response['success'])) {
            $this->redirect("/users");
        } elseif (isset($response['error'])) {
            $error = $response['error'];
            $this->render("/users/index", ['error' => $error]);
        }
    }


}

//echo "<pre>";
//print_r($errors);
//echo "</pre>";
//die();
