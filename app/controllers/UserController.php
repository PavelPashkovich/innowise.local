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
        $this->render('/users/index.twig', $data);
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $this->render('/users/create.twig');
    }

    /**
     * @param $validationData
     * @return void
     */
    public function store($validationData): void
    {
        $errors = (new UserStoreRequest())->validate($validationData);
        if (!empty($errors)) {
            $this->render('users/create.twig', ['errors' => $errors]);
            return;
        }
        $response = (new User())->insert($validationData);
        $data = $this->prepareUserResponse($response);
        if (array_key_exists('users', $data)) {
            $this->redirect("/users/{$data['users']}");
        } else {
            $this->render('/users/create.twig', ['error' => $data['error']]);
        }

    }

    /**
     * @param $id
     * @return void
     */
    public function show($id): void
    {
        $response = (new User())->find($id);
        $data = $this->prepareUserResponse($response);
        $this->render('/users/show.twig', $data);
    }

    /**
     * @param $id
     * @return void
     */
    public function edit($id): void
    {
        $response = (new User())->find($id);
        $data = $this->prepareUserResponse($response);
        $this->render('/users/edit.twig', $data);
    }

    /**
     * @param $validationData
     * @return void
     */
    public function update($validationData): void
    {
        $response = (new User())->find($validationData['id']);
        if (isset($response['error'])) {
            $this->render("/users/edit.twig", ['error' => $response['error']]);
            return;
        }
        $data = $this->prepareUserResponse($response);
        $errors = (new UserStoreRequest())->validate($validationData);
        if (!empty($errors)) {
            $data['errors'] = $errors;
            $this->render('users/edit.twig', $data);
            return;
        }
        $res = (new User)->update($validationData);
        $savedUserId = $res['success'] ?? null;
        $data = $this->prepareUserResponse($res);
        if (is_null($savedUserId)) {
            $this->render('/users/edit.twig', $data);
        } else {
            $this->redirect("/users/$savedUserId");
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function destroy($id): void
    {
        $response = (new User())->find($id);
        if (isset($response['error'])) {
            $this->render("/users/index.twig", ['error' => $response['error']]);
            return;
        }
        $response = (new User())->delete($id);
        if (isset($response['success'])) {
            $this->redirect("/users");
        } elseif (isset($response['error'])) {
            $error = $response['error'];
            $this->render("/users/index.twig", ['error' => $error]);
        }

    }

    public function destroyMultiple() {
        $ids = $_POST['ids'] ?? [];
        $idErrors = [];
        foreach ($ids as $id) {
            $response = (new User())->find($id);
            if (isset($response['error'])) {
                $idErrors[] = $response['error'];
            }
        }
        if (empty($idErrors)) {
            foreach ($ids as $id) {
                (new User())->delete($id);
            }
            $this->redirect("/users");
        } else {
            $this->render("/users/index.twig", ['idErrors' => $idErrors]);
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

}
