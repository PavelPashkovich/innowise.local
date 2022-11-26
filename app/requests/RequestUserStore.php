<?php

namespace app\requests;

use app\models\User;
use PDO;
use system\DataBase;
use system\Validation;

class RequestUserStore implements Validation
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
        try {
            $connection = DataBase::getConnection();
            $tableName = (new User())->getTableName();
            $sql = "SELECT COUNT(*) FROM " . $tableName . " WHERE email = '$email'";
            $result = $connection->query($sql);
            $count = $result->fetchColumn();
            if ($count) {
                $errors['email_error'] = 'Email already exists!';
            }
        } catch (\PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }

        return $errors;
    }
}