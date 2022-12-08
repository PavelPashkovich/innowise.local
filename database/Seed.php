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
                ('Mantis', 'mantis@marvel.com', 'female', 'active'),
                ('Irom Man', 'iron-man@marvel.com', 'male', 'active'),
                ('Hulk', 'hulk@marvel.com', 'male', 'active'),
                ('Captain America', 'captain-america@marvel.com', 'male', 'active'),
                ('Black Widow', 'black-widow@marvel.com', 'female', 'active'),
                ('Ant Man', 'ant-man@marvel.com', 'male', 'active'),
                ('Thor', 'thor@marvel.com', 'male', 'active'),
                ('Clint Barton', 'clint-barton@marvel.com', 'male', 'inactive'),
                ('Spider Man', 'spider-man@marvel.com', 'male', 'inactive'),
                ('Black Panther', 'black-panther@marvel.com', 'male', 'active'),
                ('Doctor Strange', 'doctor-strange@marvel.com', 'male', 'active'),
                ('Bucky Barnes', 'bucky-barnes@marvel.com', 'male', 'active'),
                ('Valkyrie', 'valkyrie@marvel.com', 'female', 'active'),
                ('Wanda', 'wanda@marvel.com', 'female', 'active'),
                ('Loki', 'loki@marvel.com', 'male', 'inactive'),
                ('Captain Marvel', 'captain-marvel@marvel.com', 'female', 'active'),
                ('Wong', 'wong@marvel.com', 'male', 'active'),
                ('Vision', 'vision@marvel.com', 'male', 'active')
            ";
            $connection->query($sql);
        } catch (\PDOException $exception) {
            echo "Database error: " . $exception->getMessage();
        }

    }
}