<?php

namespace SM\Controllers;

use Simple\Helpers\Session;

class Logout
{
    public static function Logout()
    {
        Session::destroy();
        header('location: /login');
    }
}
