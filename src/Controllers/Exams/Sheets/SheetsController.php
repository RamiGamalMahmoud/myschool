<?php

namespace SM\Controllers\Exams\Sheets;

use Exception;
use config\DBConfig;
use Simple\Core\IRequest;
use SM\Repos\Exams\Sheets\ISheetRepo;
use SM\Views\Exams\Sheets\ISheetView;
use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\Exams\Sheets\FirstSemesterSheetRepo;
use SM\Repos\Exams\Sheets\MainSheetRepo;
use SM\Views\Exams\Sheets\FirstSemesterSheetView;
use SM\Views\Exams\Sheets\MainSheetView;

class SheetsController
{
    private ISheetRepo $repo;

    /**
     * @var \Simple\Core\Request 
     */
    protected IRequest $request;

    /**
     * @var FirstSemesterSheetView
     */
    protected ISheetView $view;

    public function __construct(IRequest $request, $params)
    {
        $this->request = $request;

        $this->view = $this->createView($this->request->getSegment(1), $params);
        $this->repo = $this->getRepo($params['gradeNumber'], $this->getSemester(), new MySQLAccess());
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
                return new FirstSemesterSheetRepo($gradeNumber, $dataAccess);
                break;

            case 'ss':
                return new MainSheetRepo($gradeNumber, $dataAccess);
                break;
        }
    }

    private function createView(string $semester, ?array $params): ISheetView
    {
        if ($semester === 'fs') {
            return new FirstSemesterSheetView($params);
        } elseif ($semester === 'ss') {
            return new MainSheetView($params);
        } else {
            throw new Exception();
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
