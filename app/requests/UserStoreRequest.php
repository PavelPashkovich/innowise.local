<?php

namespace app\requests;

use app\models\User;
use system\DataBase;
use system\Validation;

class UserStoreRequest implements Validation
{
    public function validate($data): array
    {
        $name = trim($data['name']);
        $email = trim($data['email']);

        $errors = [];

        // Validate name
        if (!preg_match('#^[a-zA-Z_ -]+$#', $name) || strlen($name) < 2) {
            $errors['name_error'] = 'Name must contain only letters (min 2 characters)!';
        }

        // Validate email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email_error'] = 'You must enter a valid email!';
            return $errors;
        }

        // Validate email existence
        if (isset($data['id'])) {
            $response = (new User())->find($data['id']);
            $user = $response['success'];
            if ($user['email'] == $email) {
                return $errors;
            }
        }

        $user = new User();
        $response = $user->checkEmailExistence($email);
        if (isset($response['success'])) {
            $emailExists = $response['success'];
            if ($emailExists) {
                $errors['email_error'] = "Email $email already exists!";
            }
        } elseif (isset($response['error'])) {
            $errors['database_error'] = $response['error'];
        }

//        $user = new User();
//        $emailExists = DataBase::checkEmailExistence($user, $email);
//        if ($emailExists) {
//            $errors['email_error'] = "Email $email already exists!";
//        }

        return $errors;
    }
}