<?php

namespace SM\Controllers;

use Simple\Core\Redirect;
use Simple\Core\Session;

class Logout
{
    public static function Logout()
    {
        Session::destroy();
        Redirect::to('/login');
    }
}
