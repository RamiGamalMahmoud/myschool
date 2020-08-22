<?php

namespace SM\Controllers;

use Simple\Core\Request;
use SM\MiddleWares\Auth;
use Simple\Helpers\Session;
use SM\Core\View;

class Login
{
    public function login()
    {
        View::render('login.twig');
    }

    public function authenticate(Request $request)
    {
        if (Auth::authenticate($request)) {
            $location = Session::get('userType');
            header('location: /' . $location);
        }
    }
}
