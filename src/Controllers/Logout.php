<?php

namespace SM\Controllers;

use Simple\Core\Session;

class Logout
{
    public static function Logout()
    {
        Session::destroy();
        header('location: /login');
    }
}
