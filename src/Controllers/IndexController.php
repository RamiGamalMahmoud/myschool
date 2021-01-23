<?php

namespace SM\Controllers;

use Simple\Core\Session;

class IndexController
{
    public function index()
    {
        $location = Session::get('user-type');
        header('location: /' . $location);
    }
}
