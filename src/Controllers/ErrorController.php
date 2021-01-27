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
        exit;
    }

    public static function pageNotFound($message = '', $description = '')
    {
        self::$context = [
            'code' => 404,
            'message' => $message === '' ? 'page not found' : $message,
            'description' => $description === '' ? 'you are trying to visit page that not exist' : $description
        ];
        http_response_code(404);
        self::render();
        exit;
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
        exit;
    }

    public static function authorizationError()
    {
        self::$context = [
            'code' => 401,
            'message' => 'authorization failed',
            'description' => 'you are not authorized to access this url'
        ];
        http_response_code(401);
        self::render();
        exit;
    }

    public static function api()
    {
        http_response_code(404);
        echo 'request url not exists';
        exit;
    }
}
