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
                ('Ronan', 'ronan@marvel.com', 'male', 'inactive'),
                ('Rocket1', 'rocket1@marvel.com', 'male', 'active'),
                ('Groot1', 'groot1@marvel.com', 'male', 'active'),
                ('Star-lord1', 'star-lord1@marvel.com', 'male', 'active'),
                ('Gamora1', 'gamora1@marvel.com', 'female', 'active'),
                ('Drax1', 'drax1@marvel.com', 'male', 'active'),
                ('Nebula1', 'nebula1@marvel.com', 'female', 'active'),
                ('Yondu Udonta1', 'yondu-udonta1@marvel.com', 'male', 'active'),
                ('Thanos1', 'thanos1@marvel.com', 'male', 'inactive'),
                ('Ronan1', 'ronan1@marvel.com', 'male', 'inactive'),
                ('Rocket2', 'rocket2@marvel.com', 'male', 'active'),
                ('Groot2', 'groot2@marvel.com', 'male', 'active'),
                ('Star-lord2', 'star-lord2@marvel.com', 'male', 'active'),
                ('Gamora2', 'gamora2@marvel.com', 'female', 'active'),
                ('Drax2', 'drax2@marvel.com', 'male', 'active'),
                ('Nebula2', 'nebula2@marvel.com', 'female', 'active'),
                ('Yondu Udonta2', 'yondu-udonta2@marvel.com', 'male', 'active'),
                ('Thanos2', 'thanos2@marvel.com', 'male', 'inactive'),
                ('Ronan2', 'ronan2@marvel.com', 'male', 'inactive')
            ";
            $connection->query($sql);
        } catch (\PDOException $exception) {
            echo "Database error: " . $exception->getMessage();
        }

    }
}