<?php

namespace SM\Controllers\Exams\Sheets;

use SM\Repos\IReadRepo;
use config\DBConfig;
use Simple\Core\View;
use Simple\Core\IRequest;
use Simple\Helpers\Functions;
use SM\Controllers\BaseController;
use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\Exams\Sheets\FirstSemesterSheetRepo;
use SM\Repos\Exams\Sheets\SecondSemesterSheetRepo;

class SheetsController extends BaseController
{
  private IReadRepo $repo;

  public function __construct(IRequest $request, $params)
  {
    parent::__construct($request, $params);
    $this->view = 'exams/fs-sheet/fs-sheet.twig';
    $this->repo = $this->getRepo($params['gradeNumber'], $this->getSemester(), new MySQLAccess(new DBConfig()));
  }

  /**
   * Get data from The Repo and loads the view
   * Then return the view with data
   * @return string
   */
  public function index()
  {
    $this->context['entities'] = $this->show();
    return $this->loadView($this->context);
  }

  /**
   * Loads view template
   * @return string
   */
  public function loadView(array $context)
  {
    return View::load($this->view, $context);
  }

  /**
   * Show Entity for the suplied $id,
   * If $id is empty it will returns all entities.
   * @param mix $id
   * @return array 
   */
  public function show($id = '')
  {
    return $this->repo->getAll();
  }

  /**
   * Get the Repo as the semester
   * @param int $gradeNumber
   * @param string $semester
   * @param Simple\Core\DataAccess\IDataAccess $dataAccess
   * @return SM\Repos\IReadRepo
   */
  private function getRepo(int $gradeNumber, string $semester, IDataAccess $dataAccess)
  {
    switch ($semester) {
      case 'fs':
        return new FirstSemesterSheetRepo($semester, $gradeNumber, $dataAccess);
        break;

      case 'ss':
        return new SecondSemesterSheetRepo($semester, $gradeNumber, $dataAccess);
        break;
    }
  }

  /**
   * Exatract the semester from the request object
   * @return int
   */
  private function getSemester()
  {
    return $this->request->getSegment(1);
  }
}
