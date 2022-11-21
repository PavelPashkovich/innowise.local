<?php

namespace system;

class View
{
    /**
     * @param string $path
     * @param array $data
     * @return void
     */
    public static function render(string $path, array $data = []): void
    {
        $fullPath = __DIR__ . '/../app/views/' . $path . '.php';

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }

//        $messages = require_once __DIR__ . '/../config/messages.php';

        if (file_exists($fullPath) && is_file($fullPath)) {
            include($fullPath);
        } else {
            View::render('notFound');
        }
    }
}
