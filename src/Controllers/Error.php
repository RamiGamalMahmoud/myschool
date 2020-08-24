<?php

namespace SM\Controllers;

use Simple\Core\View;

class Error
{
    public static function error()
    {
        http_response_code(404);
        View::render('errors/error.twig');
    }
}