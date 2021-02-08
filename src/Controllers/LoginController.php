<?php

namespace SM\Controllers;

use Simple\Core\Redirect;
use Simple\Core\Request;
use Simple\Core\Router;
use Simple\Core\Session;
use SM\MiddleWares\Auth;
use Simple\Core\View;

class LoginController
{
    private Request $request;

    private Router $router;

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;
    }
    public function showLogin()
    {
        View::render('login.twig');
    }

    public function doLogin()
    {
        $params = $this->request->getRequestBody()['post'];
        $userName = isset($params['userName']) && !empty($params['userName']) ? $params['userName'] : false;
        $password = isset($params['password']) && !empty($params['password']) ? $params['password'] : false;

        if (!$userName) {
            $this->displayErrors();
        }

        if (!$password) {
            $this->displayErrors();
        }

        $userData = Auth::authenticate($userName, $password);
        if (!empty($userData)) {
            $this->logUser($userData);
            Redirect::to('/');
        } else {
            $this->displayErrors();
        }
    }

    private function displayErrors()
    {
        View::render('login.twig');
    }

    private function logUser(array $userData)
    {
        foreach ($userData as $key => $value) {
            Session::set($key, $value);
        }
    }
}
