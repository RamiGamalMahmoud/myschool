<?php

namespace SM\Controllers\Exams\Sheets;

use Exception;
use Simple\Core\Router;
use Simple\Core\IRequest;
use SM\Repos\Exams\Sheets\ISheetRepo;
use SM\Views\Exams\Sheets\ISheetView;
use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\Exams\Sheets\MainSheetRepo;
use SM\Views\Exams\Sheets\MainSheetView;
use SM\Repos\Exams\Sheets\FirstSemesterSheetRepo;
use SM\Views\Exams\Sheets\FirstSemesterSheetView;

class SheetsController
{
    /**
     * @var \SM\Repos\Exams\Sheets\ISheetRepo
     */
    private ISheetRepo $repo;

    /**
     * @var \Simple\Core\Request 
     */
    private IRequest $request;

    /**
     * @var Simple\Core\Router
     */
    private Router $router;

    /**
     * @var FirstSemesterSheetView
     */
    private ISheetView $view;

    public function __construct(IRequest $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;

        $semester = $this->router->get('semester');
        $gradeNumber = $this->router->get('gradeNumber');

        $this->view = $this->createView($gradeNumber, $semester);
        $this->repo = $this->getRepo($gradeNumber, $semester, new MySQLAccess());
    }

    /**
     * Get data from The Repo and loads the view
     * Then return the view with data
     * @return string
     */
    public function index()
    {
        $status = $this->router->get('status');
        if ($status === 'all') {
            $this->view->render($this->showAll());
        } elseif ($status === 'passed') {
            $this->view->render($this->repo->getPassedStudents());
        } elseif ($status === 'failed') {
            $this->view->render($this->repo->getFailedStudents());
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

    private function createView(int $gradeNumber, string $semester): ISheetView
    {
        if ($semester === 'fs') {
            return new FirstSemesterSheetView($gradeNumber);
        } elseif ($semester === 'ss') {
            return new MainSheetView($gradeNumber);
        } else {
            throw new Exception();
        }
    }
}
