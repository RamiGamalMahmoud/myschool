<?php

namespace SM\Controllers\Exams;

use Simple\Core\Request;
use Simple\Core\Router;
use Simple\Core\Session;
use SM\Views\Exams\ExamsView;

class ExamsController
{
    /**
     * @var string
     */
    protected ExamsView $view;

    public function __construct(Request $request, Router $router)
    {
        $viewParams = [
            'gradeNumber' => $router->get('gradeNumber'),
            'fullName' => Session::get('user-full-name')
        ];
        $this->view = new ExamsView($viewParams);
    }

    /**
     * Display the default state of the exams page
     * 
     * Calls the getGradeNumber method and then render the view
     */
    public function index()
    {
        $this->view->render();
    }
}
