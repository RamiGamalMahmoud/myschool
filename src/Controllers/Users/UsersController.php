<?php

namespace SM\Controllers\Users;

use Exception;
use Simple\Core\View;
use Simple\Helpers\Session;
use SM\Controllers\BaseController;
use SM\Models\Users\UsersModel;

class UsersController extends BaseController
{
    public function __construct($request, $params)
    {
        Session::start();
        if (Session::get('userType') !== 'admin') {
            throw new Exception('You are not authorized !');
        }

        $this->view = 'users/users.twig';
        $this->model = new UsersModel();
        $this->request = $request;
        $this->context = $params;
    }

    /**
     * index fetching the users data then display it
     * @param void
     */
    public function index()
    {
        $this->context['data'] = $this->model->getAll();
        $this->render($this->context);
    }

    public function render($context)
    {
        View::render($this->view, $context);
    }
}
