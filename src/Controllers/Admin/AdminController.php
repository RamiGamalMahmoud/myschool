<?php

namespace SM\Controllers\Admin;

use SM\Models\Admin\UserModel;
use SM\Models\IModel;
use Simple\Core\Dispatcher;
use Simple\Core\Request;
use Simple\Core\Router;
use Simple\Helpers\Session;
use Simple\Core\View;

class AdminController
{
    private IModel $model;
    private $view;
    private $context;
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model = new UserModel();
        $this->context['fullName'] = Session::get('fullName');
        $this->view = 'admin/admin.twig';
    }
    public function index()
    {
        $this->model->read();
        $this->render($this->context);
    }

    public function render($context)
    {
        View::render($this->view, $context);
    }

    public function showUsers()
    {
        $this->context['contentTemplate'] = 'admin/users.twig';
        $usersData = $this->model->read();
        $this->context['data'] = $usersData;
        $this->render($this->context);
    }

    public function updateUser()
    {
    }

    public function deleteUser()
    {
    }

    private function reRoute($parentContext)
    {
        $newPath = explode('/', $this->request->getPath(), 2)[1];

        $newRequest = new Request($newPath);
        $router = new Router($newRequest->getPath(), $newRequest->getRequestMethod());

        Dispatcher::dispatche($router->route()['route'], $newRequest, $parentContext);
    }

    public function exams()
    {
        $parentContext = [
            'parentTemplate' => $this->view,
            'fullName' => $this->context['fullName'],
            'linkPrefex' => '/admin/exams'
        ];
        $this->reRoute($parentContext);
    }
}
