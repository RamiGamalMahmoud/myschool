<?php

namespace SM\Controllers\Exams;

use Simple\Core\View;
use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\IRequest;
use Simple\Core\Dispatcher;
use SM\Controllers\BaseController;

class ExamsController extends BaseController
{
  public function __construct(IRequest $request, $params)
  {
    parent::__construct($request, $params);
    $linkPrefex = isset($params['linkPrefex']) ? $params['linkPrefex'] . '/exams' : '/exams';
    $this->context['linkPrefex'] = $linkPrefex;
    $this->view = 'exams/exams.twig';
  }

  /**
   * Display the default state of the exams page
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
   * 
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
    $request = new Request($this->getNewPath());
    $router = new Router($request, ROUTES_FOLDER);
    $this->context['child'] = Dispatcher::dispatche($router->route(), $request, $this->context);
    $this->render($this->context);
  }

  protected function getNewPath()
  {
    return implode('/', array_slice($this->request->getSegments(), 2));
  }
}
