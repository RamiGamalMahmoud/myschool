<?php

namespace SM\Controllers\Admin;

use Simple\Core\IRequest;
use Simple\Core\Session;
use Simple\Core\Simple;
use Simple\Core\View;
use Simple\EXceptions\RoutingException;
use SM\Controllers\BaseController;

class AdminController extends BaseController
{

    public function __construct(IRequest $request)
    {
        Session::start();
        parent::__construct($request, []);
        $this->context['fullName'] = Session::get('fullName');
        $this->view = 'admin/admin.twig';
    }
    public function index()
    {
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

    public function reRoute()
    {
        $parentContext = [
            'fullName' => $this->context['fullName'],
            'parentTemplate' => $this->view,
            'linkPrefex' => '/admin'
        ];

        $newPath = explode('/', $this->request->getPath(), 2)[1];
        try {
            Simple::resolve($newPath, $parentContext);
        } catch (RoutingException $e) {
        }
        return;
    }
}
