<?php

namespace SM\Controllers\StudentsAffairs;

use Simple\Core\Request;
use Simple\Core\Router;
use SM\Controllers\BaseController;
use SM\Services\StudentsAffairs\StudentsAffairsService;
use SM\Views\StudentsAffairs\StudentsAffairsView;

class StudentsAffairsController extends BaseController
{
    private StudentsAffairsService $studentsAffarisService;

    protected StudentsAffairsView $view;

    public function __construct(Request $request, Router $router)
    {
        parent::__construct($request, $router);
        $this->studentsAffarisService = new StudentsAffairsService();
        $this->view = new StudentsAffairsView(['gradesData' => $this->getGradesAndClassrooms()]);
    }

    public function index()
    {
        $this->view->render();
    }

    private function getGradesAndClassrooms()
    {
        $grades = $this->studentsAffarisService->getGrades();

        $classrooms = $this->studentsAffarisService->getClassRooms();

        $gradesAndRooms = array_map(function ($grade) use ($classrooms) {
            $classesInGrade = [];
            foreach ($classrooms as $classroom) {
                if ($grade->getGradeNumber() == $classroom->getGradeNumber()) {
                    array_push($classesInGrade, $classroom);
                }
            }
            return $classesInGrade;
        }, $grades);
        return $gradesAndRooms;
    }
}
