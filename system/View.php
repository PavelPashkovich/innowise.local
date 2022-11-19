<?php

namespace system;

class View
{
    /**
     * @param string $path
     * @param array $data
     * @return void
     * @throws \ErrorException
     */
    public static function render(string $path, array $data = [])
    {
        $fullPath = __DIR__ . '/../app/views/' . $path . '.php';

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $$key = $value;
            }
        }

        $messages = (require_once __DIR__ . '/../config/messages.php')['messages'];

        if (file_exists($fullPath) && is_file($fullPath)) {
            include($fullPath);
        } else {
            throw new \ErrorException($messages['view can not be found']);
        }
    }
}
