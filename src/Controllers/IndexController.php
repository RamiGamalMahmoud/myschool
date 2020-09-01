<?php

namespace SM\Controllers;

use Simple\Helpers\Session;

class IndexController
{
    public function index()
    {
        $location = Session::get('userType');
        header('location: /' . $location);
    }

    public function sayHi()
    {
        echo 'Welcome to API';
    }
}
