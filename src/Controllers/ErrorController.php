<?php

namespace SM\Controllers;

use Simple\Core\View;

class ErrorController
{
    private static array $context;
    private static string $template = 'errors/error.twig';

    public static function render()
    {
        View::render(self::$template, self::$context);
    }

    public static function internalError()
    {
        self::$context = [
            'code' => 500,
            'message' => 'internal server error',
            'description' => 'we are sorry, this is an internal server error'
        ];
        http_response_code(500);
        self::render();
    }

    public static function pageNotFound()
    {
        self::$context = [
            'code' => 404,
            'message' => 'page not found',
            'description' => 'you are trying to visit page that not exist'
        ];
        http_response_code(404);
        self::render();
    }

    public static function resourcesRemoved()
    {
        self::$context = [
            'code' => 410,
            'message' => 'page not found',
            'description' => 'sorry, the resources you requested has been deleted'
        ];
        http_response_code(410);
        self::render();
    }

    public static function api()
    {
        http_response_code(404);
        echo 'request url not exists';
        exit;
    }
}
