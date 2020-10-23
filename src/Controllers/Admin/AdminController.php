<?php

namespace SM\Controllers\Admin;

use Simple\Core\Dispatcher;
use Simple\Core\Request;
use Simple\Core\IRequest;
use Simple\Core\Router;
use Simple\Core\Session;
use Simple\Core\View;
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

    $newRequest = new Request($newPath);
    $router = new Router($newRequest, ROUTES_FOLDER);

    Dispatcher::dispatche($router->route(), $newRequest, $parentContext);
  }
}
