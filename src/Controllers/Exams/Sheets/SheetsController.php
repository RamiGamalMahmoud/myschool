<?php

namespace SM\Controllers\Exams\Sheets;

use Exception;
use config\DBConfig;
use Simple\Core\IRequest;
use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\MySQLAccess;
use Simple\Helpers\Functions;
use SM\Repos\Exams\Sheets\FirstSemesterSheetRepo;
use SM\Views\Exams\Sheets\FirstSemesterSheetView;
use SM\Repos\Exams\Sheets\IFirstSemesterSheetRepo;
use SM\Repos\Exams\Sheets\SecondSemesterSheetRepo;

class SheetsController
{
    private IFirstSemesterSheetRepo $repo;

    /**
     * @var \Simple\Core\Request 
     */
    protected IRequest $request;

    /**
     * @var FirstSemesterSheetView
     */
    protected FirstSemesterSheetView $view;

    public function __construct(IRequest $request, $params)
    {
        $this->request = $request;

        $this->view = new FirstSemesterSheetView($request->getSegment(1), $params);
        $this->repo = $this->getRepo($params['gradeNumber'], $this->getSemester(), new MySQLAccess(new DBConfig()));
    }

    /**
     * Get data from The Repo and loads the view
     * Then return the view with data
     * @return string
     */
    public function index()
    {
        $status = $this->request->getSegment(2);
        if ($status === 'all') {
            return $this->view->load($this->showAll());
        } elseif ($status === 'passed') {
            return $this->view->load($this->repo->getPassedStudents());
        } elseif ($status === 'failed') {
            return $this->view->load($this->repo->getFailedStudents());
        } else {
            // error page
        }
    }

    /**
     * Show Entity for the suplied $id,
     * If $id is empty it will returns all entities.
     * @param mix $id
     * @return array 
     */
    public function show($id = '')
    {
        throw new Exception('not implemented');
    }

    /**
     * Show all entities
     * @return array
     */
    public function showAll()
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
