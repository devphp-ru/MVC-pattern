<?php

namespace base;

trait TNotFound
{
    /**
     * метод, передает код 404
     * и выводит страницу 404
     */
    public static function notFound()
    {
        http_response_code(404);
        require SITE . '/404.php';
        die;
    }
}
