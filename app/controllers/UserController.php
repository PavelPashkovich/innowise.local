<?php

namespace app\controllers;

use app\models\User;
use app\requests\UserStoreRequest;
use system\Request;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="REST API Docs", version="1.0")
 * @OA\Scheme(format="http")
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         in="header",
 *         name="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT",
 *     )
 * )
 */

class UserController extends Controller
{

    /**
     * @OA\Get(
     *     path="/users",
     *     summary="Get all list of users",
     *     tags={"Users"},
     *     @OA\Response(response="200", description="Success"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request): void
    {
        $params = $request->getParams();
        $dataSource = $request->getDataSource();
        $response = (new User)->all($params, $dataSource);

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
     * @OA\Post(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Add a new user",
     *     description="Returns a single user",
     *     operationId="store",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "email", "gender", "status"},
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="gender", type="string", enum={"male", "female"}, default="male"),
     *                 @OA\Property(property="status", type="string", enum={"active", "inactive"}, default="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $postData = $request->getPostData();
        $dataSource = $request->getDataSource();
        $postData['dataSource'] = $request->getDataSource();
        $errors = (new UserStoreRequest())->validate($postData);
        if (!empty($errors)) {
            $this->render('users/create.twig', ['errors' => $errors]);
            return;
        }
        unset($postData['dataSource']);
        $response = (new User())->insert($postData, $dataSource);
        $data = $this->prepareUserResponse($response);
        if (!empty($data['users'])) {
            $this->redirect("/users/{$data['users']['id']}");
        } else {
            $this->render('/users/create.twig', ['error' => $data['error']]);
        }

    }

    /**
     * @OA\Get(
     *     path="/users/{userId}",
     *     tags={"Users"},
     *     summary="Find user by ID",
     *     description="Returns a single user",
     *     operationId="show",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID of user to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return void
     */
    public function show(Request $request): void
    {
        $id = $request->getId();
        $dataSource = $request->getDataSource();
        $response = (new User())->find($id, $dataSource);
        $data = $this->prepareUserResponse($response);
        $this->render('/users/show.twig', $data);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function edit(Request $request): void
    {
        $id = $request->getId();
        $dataSource = $request->getDataSource();
        $response = (new User())->find($id, $dataSource);
        $data = $this->prepareUserResponse($response);
        $this->render('/users/edit.twig', $data);
    }

    /**
     * @OA\Post(
     *     path="/users/update",
     *     tags={"Users"},
     *     summary="Update user",
     *     description="Updates a single user",
     *     operationId="update",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"id", "name", "email", "gender", "status"},
     *                 @OA\Property(property="id", type="string"),
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="email", type="string"),
     *                 @OA\Property(property="gender", type="string", enum={"male", "female"}, default="male"),
     *                 @OA\Property(property="status", type="string", enum={"active", "inactive"}, default="active")
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request): void
    {
        $postData = $request->getPostData();
        $dataSource = $request->getDataSource();
        $response = (new User())->find($postData['id'], $dataSource);
        if (!empty($response['error'])) {
            $this->render("/users/edit.twig", ['error' => $response['error']]);
            return;
        }
        $data = $this->prepareUserResponse($response);

        $postData['dataSource'] = $dataSource;
        $errors = (new UserStoreRequest())->validate($postData);
        if (!empty($errors)) {
            $data['errors'] = $errors;
            $this->render('users/edit.twig', $data);
            return;
        }
        unset($postData['dataSource']);
        $res = (new User)->update($postData, $dataSource);
        $savedUserId = $res['success']['id'] ?? null;
        $data = $this->prepareUserResponse($res);
        if (is_null($savedUserId)) {
            $this->render('/users/edit.twig', $data);
        } else {
            $this->redirect("/users/$savedUserId");
        }
    }

    /**
     * @OA\Post(
     *     path="/users/{userId}",
     *     tags={"Users"},
     *     summary="Delete user",
     *     operationId="delete",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="User id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(response="200", description="Success"),
     *     security={
     *         {"bearerAuth": {}}
     *     }
     * )
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $id = $request->getId();
        $dataSource = $request->getDataSource();
        $response = (new User())->find($id, $dataSource);
        if (!empty($response['error'])) {
            $this->render("/users/index.twig", ['error' => $response['error']]);
            return;
        }
        $response = (new User())->delete($id, $dataSource);
        if (isset($response['success']) || $response['success'] === null) {
            $this->redirect("/users");
        } elseif (isset($response['error'])) {
            $error = $response['error'];
            $this->render("/users/index.twig", ['error' => $error]);
        }

    }

    public function destroyMultiple(Request $request) {
        $dataSource = $request->getDataSource();
        $postData = $request->getPostData();
        $ids = $postData['ids'];
        $idErrors = [];
        foreach ($ids as $id) {
            $response = (new User())->find($id, $dataSource);
            if (!empty($response['error'])) {
                $idErrors[] = $response['error'];
            }
        }
        if (empty($idErrors)) {
            foreach ($ids as $id) {
                (new User())->delete($id, $dataSource);
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
        if (!empty($response['success'])) {
            $data = ['users' => $response['success']];
            $data['total_pages'] = $response['total_pages'] ?? '';
            $data['page'] = $response['page'] ?? '';
        }
        if (!empty($response['error'])) {
            $data = ['error' => $response['error']];
        }
        return $data;
    }

}
