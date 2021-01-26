<?php

namespace SM\Controllers\Users;

use Simple\Core\View;
use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\Session;
use SM\Repos\Users\UserRepo;
use Simple\Core\DataAccess\MySQLAccess;
use SM\Exceptions\AuthorizationException;
use SM\Repos\Users\IUserRepo;

class UserController
{
    /**
     * @var \SM\Repos\Users\IUserRepo
     */
    private IUserRepo $usersRepo;

    /**
     * Contructing the object
     * 
     * @param \Simple\Core\Request $request
     * @param \Simple\Core\Router
     */
    public function __construct(Request $request, Router $router)
    {
        if (Session::get('group-name') !== 'admin') {
            throw new AuthorizationException();
        }

        $this->view = 'users/users.twig';

        $this->usersRepo = new UserRepo(new MySQLAccess());
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

    /**
     * Rendering the template
     * 
     * @param array $context
     */
    public function render($context)
    {
        View::render('users/users.twig', $context);
    }
}
