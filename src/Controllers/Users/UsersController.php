<?php

namespace SM\Controllers\Users;

use Simple\Core\View;
use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\Session;
use SM\Repos\Users\UsersRepo;
use Simple\Core\DataAccess\MySQLAccess;
use SM\Exceptions\AuthorizationException;

class UsersController
{
    private UsersRepo $usersRepo;

    public function __construct(Request $request, Router $router)
    {
        if (Session::get('group-name') !== 'admin') {
            throw new AuthorizationException();
        }

        $this->view = 'users/users.twig';

        $this->usersRepo = new UsersRepo(new MySQLAccess());
    }

    /**
     * index fetching the users data then display it
     * @param void
     */
    public function index()
    {
        $users = $this->usersRepo->getAll();
        $this->context['data'] = $users;
        $this->render($this->context);
    }

    public function render($context)
    {
        View::render('users/users.twig', $context);
    }
}
