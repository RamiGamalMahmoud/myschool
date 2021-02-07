<?php

namespace SM\Controllers;

use Simple\Core\Redirect;
use Simple\Core\Session;
use SM\MiddleWares\Auth;

class IndexController
{
    public function index()
    {
        if (!Auth::isAuthenticated()) {
            Redirect::to('/login');
        }

        $location = Session::get('group-name');
        header('location: /' . $location);
    }
}
