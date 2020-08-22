<?php

namespace SM\Controllers;

use SM\Core\Util\Session;

class IndexController
{
    public function index()
    {
        $location = Session::get('userType');
        header('location: /' . $location);
    }
}
