<?php

namespace SM\Controllers\Users;

use Exception;
use Simple\Core\DataAccess\MySQLAccess;
use Simple\Core\View;
use Simple\Core\Session;
use SM\Controllers\BaseController;
use SM\Repos\Users\UsersRepo;
use config\DBConfig;

class UsersController extends BaseController
{
    private UsersRepo $usersRepo;
    public function __construct($request, $params)
    {
        Session::start();
        if (Session::get('userType') !== 'admin') {
            throw new Exception('You are not authorized !');
        }

        $this->view = 'users/users.twig';

        $this->usersRepo = new UsersRepo(new MySQLAccess(new DBConfig()));

        parent::__construct($request, $params);
    }

    /**
     * index fetching the users data then display it
     * @param void
     */
    public function index()
    {
        $this->context['data'] = $this->usersRepo->getAll();
        $this->render($this->context);
    }

    public function render($context)
    {
        View::render($this->view, $context);
    }
}
