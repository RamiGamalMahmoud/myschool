<?php

namespace SM\Controllers\Exams;

use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\IRequest;
use Simple\Core\Dispatcher;
use SM\Views\Exams\ExamsView;
use SM\Services\SessionUserData;

class ExamsController
{
    /**
     * @var array
     */
    protected ?array $viewContext;

    /**
     * @var \Simple\Core\Request
     */
    protected IRequest $request;

    /**
     * @var string
     */
    protected ExamsView $view;

    public function __construct(IRequest $request, $params = null)
    {
        $this->request = $request;
        $this->viewContext = $params;

        $currentUser = new SessionUserData();
        $this->view = new ExamsView($params);
        $this->view->setContextItem('fullName', $currentUser->getUserName());
    }

    /**
     * Display the default state of the exams page
     * 
     * Calls the getGradeNumber method and then render the view
     */
    public function index()
    {
        $this->view->setContextItem('gradeNumber', $this->getGradeNumber()['gradeNumber']);
        $this->view->render();
    }

    /**
     * Extract ghe grade number from the path string
     * @return null|array
     */
    private function getGradeNumber()
    {
        @$gradeNumber = $this->request->getSegment(1);
        return $gradeNumber === null ? null : ['gradeNumber' => $gradeNumber];
    }

    /**
     * Remove the first and second segement from the request path then reroute
     * 
     * Takes the returned value and render the view
     * @return void
     */
    public function reRoute()
    {
        $request = new Request($this->extractNewpath());
        $router = new Router($request, ROUTES_FOLDER);
        $this->view->setContextItem('child', Dispatcher::dispatche($router->route(), $request, $this->getGradeNumber()));
        $this->view->setContextItem('gradeNumber', $this->getGradeNumber()['gradeNumber']);
        $this->view->render();
    }

    /**
     * Remove first and second segement from request then return that path
     * 
     * @return string
     */
    protected function extractNewpath()
    {
        return implode('/', array_slice($this->request->getSegments(), 2));
    }
}
