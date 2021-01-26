<?php

namespace SM\Controllers;

use Simple\Core\Session;

class IndexController
{
    public function index()
    {
        $location = Session::get('group-name');
        header('location: /' . $location);
    }
}
