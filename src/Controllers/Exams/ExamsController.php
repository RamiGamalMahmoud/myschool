<?php

namespace SM\Controllers\Exams;

use Simple\Core\View;
use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\IRequest;
use Simple\Core\Dispatcher;
use Simple\Helpers\Functions;

class ExamsController extends BaseExamsController
{
    public function __construct(IRequest $request, $params)
    {
        $linkPrefex = isset($params['linkPrefex']) ? $params['linkPrefex'] . '/exams' : '/exams';
        parent::__construct($request, $params);

        $this->context['linkPrefex'] = $linkPrefex;
        $this->view = 'exams/exams.twig';
    }

    /**
     * Views the default state of the exams page
     * 
     * Calls the updateGradeData method and then render the view
     */
    public function index()
    {
        $this->updateGradeData();
        $this->render($this->context);
    }

    /**
     * Updates $gradeNumber and $gradeName
     * 
     * Check if the grade number segement has been set
     * then update the grade number and the grade name
     * @return void
     */
    private function updateGradeData()
    {
        @$gradeNumber = $this->request->getSegment(1);
        if ($gradeNumber) {
            $this->context['gradeNumber'] = $gradeNumber;
            $this->context['gradeName'] = $this->getGradeName($gradeNumber);
        }
    }

    /**
     * Gets the grade name the $gradeNumber
     * @param int $gradeNumber
     * @return string the grade name
     */
    private function getGradeName($gradeNumber)
    {
        if ($gradeNumber == 1) {
            return 'الصف الأول';
        } elseif ($gradeNumber == 2) {
            return 'الصف الثاني';
        }

        return 'صف غير محدد';
    }

    /**
     * Rendring the view
     */
    public function render(array $context)
    {
        View::render($this->view, $context);
    }

    /**
     * Remove the first and second segement from the request path then reroute
     * 
     * Takes the returned value and render the view
     * @return void
     */
    public function reRoute()
    {
        $this->updateGradeData();
        $segments = $this->request->getSegments();

        array_shift($segments);
        array_shift($segments);
        $path = implode('/', $segments);

        $request = new Request($path);
        $router = new Router($request->getPath(), $request->getRequestMethod());
        $route = $router->route();

        if ($route) {
            $this->context['child'] = Dispatcher::dispatche($route['route'], $request, $this->context);
        } else {
            Functions::dump($route);
        }
        $this->render($this->context);
    }
}
