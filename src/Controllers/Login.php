<?php

namespace SM\Controllers;

use Simple\Core\IRequest;
use Simple\Core\Session;
use SM\MiddleWares\Auth;
use Simple\Core\View;

class Login
{
    public function login()
    {
        View::render('login.twig');
    }

    public function authenticate(IRequest $request)
    {
        if (Auth::authenticate($request)) {
            $location = Session::get('userType');
            $user = [
                'fullName' => Session::get('fullName'),
                'userName' => Session::get('userName'),
                'userType' => Session::get('userType')
            ];

            if ($request->getRequestType() === 'api') {
                echo json_encode($user);
            } else {
                header('location: /' . $location);
            }
        } else {
            return false;
        }
    }
}
