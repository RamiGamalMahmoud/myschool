<?php

namespace SM\Controllers\Admin;

use Simple\Core\View;
use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\Session;

class AdminController
{
    private string $template = 'admin/admin.twig';

    private View $view;

    private array $context = [];

    private Request $request;

    private Router $router;

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;
        $this->context['fullName'] = Session::get('user-full-name');
        $this->template = 'admin/admin.twig';
    }
    public function index()
    {
        $this->render($this->context);
    }

    public function render($context)
    {
        View::render($this->template, $context);
    }

    public function showUsers()
    {
        $this->context['contentTemplate'] = 'admin/users.twig';
        $usersData = $this->model->read();
        $this->context['data'] = $usersData;
        $this->render($this->context);
    }
}
