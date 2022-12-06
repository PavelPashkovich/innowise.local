<?php

namespace app\controllers;

use app\models\User;
use app\requests\UserStoreRequest;

class UserController extends Controller
{
    /**
     * @param array $params
     * @return void
     */
    public function index(array $params = []): void
    {
        $response = (new User)->setLimitPerPage(10)->all($params);
        $data = $this->prepareUserResponse($response);

        $this->render('/users/index', $data);
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $this->render('/users/create');
    }

    /**
     * @param $validation_data
     * @return void
     */
    public function store($validation_data): void
    {
        $errors = (new UserStoreRequest())->validate($validation_data);
        if (!empty($errors)) {
            $this->render('users/create', ['errors' => $errors]);
        } else {
            $response = (new User())->insert($validation_data);
            $data = $this->prepareUserResponse($response);
            array_key_exists('users', $data) ?
                $this->redirect("/users/{$data['users']}") :
                $this->render('/users/create', ['error' => $data['error']]);
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function show($id): void
    {
        $response = (new User())->find($id);
//        $this->printRes($response);
        $data = $this->prepareUserResponse($response);
        $this->render('/users/show', $data);
    }

    /**
     * @param $id
     * @return void
     */
    public function edit($id): void
    {
        $response = (new User())->find($id);
        $data = $this->prepareUserResponse($response);
        $this->render('/users/edit', $data);
    }

    /**
     * @param $validation_data
     * @return void
     */
    public function update($validation_data): void
    {
        $response = (new User())->find($validation_data['id']);
        $data = $this->prepareUserResponse($response);
        $errors = (new UserStoreRequest())->validate($validation_data);
        if (!empty($errors)) {
            $data['errors'] = $errors;
            $this->render('users/edit', $data);
        } else {
            $res = (new User)->update($validation_data);
            $savedUserId = $res['success'] ?? null;
            $data = $this->prepareUserResponse($res);
            is_null($savedUserId) ?
                $this->render('/users/edit', $data) :
                $this->redirect("/users/$savedUserId");
        }
    }

    /**
     * @param $id
     * @return void
     */
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

    /**
     * @param $response
     * @return array
     */
    private function prepareUserResponse($response): array
    {
        $data = [];
        if (isset($response['success'])) {
            $data = ['users' => $response['success']];
            $data['total_pages'] = $response['total_pages'] ?? '';
            $data['page'] = $response['page'] ?? '';
        }
        if (isset($response['error'])) {
            $data = ['error' => $response['error']];
        }
        return $data;
    }

    private function printRes($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

}
