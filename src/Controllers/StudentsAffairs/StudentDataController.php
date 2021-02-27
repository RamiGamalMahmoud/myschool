<?php

namespace SM\Controllers\StudentsAffairs;

use Simple\Core\Request;
use Simple\Core\Router;
use SM\Services\StudentsAffairs\StudentService;

class StudentDataController extends StudentsAffairsController
{
    /**
     * @var \SM\Services\StudentsAffairs\StudentService
     */
    private StudentService $studentService;

    public function __construct(Request $request, Router $router)
    {
        parent::__construct($request, $router);
        $this->studentService = new StudentService();
    }

    public function showAll()
    {
        $students = $this->studentService->getAllStudents();
        $this->view->showStudentsTable($students);
    }

    public function showByGradeNumber()
    {
        $gradeNumber = $this->router->get('gradeNumber');
        $students = $this->studentService->getStudentsByGradeNumber($gradeNumber);
        $this->view->showStudentsTable($students);
    }

    public function showByClassNumber()
    {
        $classNumber = $this->router->get('classNumber');
        $gradeNumber = $this->router->get('gradeNumber');
        $students = $this->studentService->getStudentsByClassNumber($gradeNumber, $classNumber);
        $this->view->showStudentsTable($students);
    }
}
