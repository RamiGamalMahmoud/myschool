<?php

namespace SM\Controllers;

use Simple\Core\View;
use stdClass;

class Error
{
    public static function error()
    {
        http_response_code(404);
        View::render('errors/error.twig');
    }

    public static function api()
    {
        http_response_code(404);
        echo 'request url not exists';
        exit;
    }
}