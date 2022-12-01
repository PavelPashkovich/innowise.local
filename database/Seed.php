<?php

namespace database;

use system\DataBase;

class Seed
{
    /**
     * @return void
     */
    public static function seed(): void
    {
        try {
            $connection = DataBase::getConnection();
            $sql = "INSERT INTO users 
                (name, email, gender, status) 
            VALUES 
                ('Rocket', 'rocket@marvel.com', 'male', 'active'),
                ('Groot', 'groot@marvel.com', 'male', 'active'),
                ('Star-lord', 'star-lord@marvel.com', 'male', 'active'),
                ('Gamora', 'gamora@marvel.com', 'female', 'active'),
                ('Drax', 'drax@marvel.com', 'male', 'active'),
                ('Nebula', 'nebula@marvel.com', 'female', 'active'),
                ('Yondu Udonta', 'yondu-udonta@marvel.com', 'male', 'active'),
                ('Thanos', 'thanos@marvel.com', 'male', 'inactive'),
                ('Ronan', 'ronan@marvel.com', 'male', 'inactive')
            ";
            $connection->query($sql);
        } catch (\PDOException $exception) {
            echo "Database error: " . $exception->getMessage();
        }

    }
}