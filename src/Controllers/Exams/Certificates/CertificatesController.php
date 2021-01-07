<?php

namespace SM\Controllers\Exams\Certificates;

use config\DBConfig;
use Exception;
use Simple\Core\DataAccess\MySQLAccess;
use Simple\Core\Request;
use Simple\Helpers\Functions;
use SM\Repos\Exams\Sheets\FirstSemesterSheetRepo;
use SM\Repos\Exams\Sheets\ISheetRepo;
use SM\Repos\Exams\Sheets\SecondSemesterSheetRepo;
use SM\Views\Exams\Certificates\CertificatesView;

class CertificatesController
{
    /**
     * @var int
     */
    private int $gradeNumber;

    /**
     * @var string
     */
    private string $semester;

    /**
     * @var string
     */
    private string $status;

    /**
     * @var \SM\Repos\Exams\Sheets\ISheetRepo
     */
    private ISheetRepo $repo;

    /**
     * @var \SM\Views\Exams\Certificates\CertificatesView
     */
    private CertificatesView $view;

    /**
     * Creates a repo for the semester
     * @param string $semester
     * @param int $gradeNumber
     * @return \SM\Repos\Exams\Sheets\ISheetRepo
     * @throws \Exception
     */
    private function createRepo(string $semester, int $gradeNumber): ISheetRepo
    {
        $dataAccess = new MySQLAccess(new DBConfig());
        if ($semester === 'fs') {
            return new FirstSemesterSheetRepo($gradeNumber, $dataAccess);
        } elseif ($semester === 'ss') {
            return new SecondSemesterSheetRepo($semester, $gradeNumber, $dataAccess);
        } else {
            throw new Exception('Semester Error');
        }
    }

    /**
     * Creates a view
     * @param string $semester
     * @param int $gradeNumber
     * @return \SM\Views\Exams\Certificates\CertificatesView
     * @throws \Exception
     */
    private function createView(string $semester, int $gradeNumber)
    {
        return new CertificatesView($semester, $gradeNumber);
    }

    public function __construct(Request $request, $params)
    {
        $this->gradeNumber = $params['gradeNumber'];
        $this->semester = $request->getSegment(1);
        $this->status = $request->getSegment(2);

        try {
            $this->repo = $this->createRepo($this->semester, $this->gradeNumber);
        } catch (Exception $e) {
            echo $e->getMessage();
        }

        try {
            $this->view = $this->createView($this->semester, $this->gradeNumber);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get data from The Repo and loads the view
     * Then return the view with data
     * @return string
     */
    public function index()
    {
        $status = $this->status;
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
     * Show all entities
     * @return array
     */
    public function showAll()
    {
        return $this->repo->getAll();
    }
}
