<?php

namespace SM\Controllers\StudentsAffairs;

use DateTime;
use Simple\Core\Request;
use Simple\Core\Router;
use SM\Services\StudentsAffairs\AbsenceService;

class StudentAbsenceController extends StudentsAffairsController
{
    private AbsenceService $absenceService;

    private DateTime $currentDate;

    public function __construct(Request $request, Router $router)
    {
        parent::__construct($request, $router);
        $this->absenceService = new AbsenceService();
    }

    public function showGradeAbsenceRegistrationTable()
    {
        $this->addDateDetailsToView();
        $gradeNumber = $this->router->get('gradeNumber');
        $studentsData = $this->absenceService->getByGrade($this->currentDate->format('Y-m'), $gradeNumber);
        $this->view->showAbsenceTable($studentsData);
    }

    public function showClassAbsenceRegistrationTable()
    {
        $this->addDateDetailsToView();
        $gradeNumber = $this->router->get('gradeNumber');
        $classNumber = $this->router->get('classNumber');
        $studentsData = $this->absenceService->getByClass($this->currentDate->format('Y-m'), $gradeNumber, $classNumber);
        $this->view->showAbsenceTable($studentsData);
    }

    public function registerStudentAbsence()
    {
        $data = $this->request->getAjaxData();
        echo $this->absenceService->registerAbsence($data->studentId, $data->date);
        exit;
    }

    private function getDateDetails()
    {
        $year = $this->request->input('year') ?? date('Y');
        $month = $this->request->input('month') ?? date('n');

        $this->currentDate = DateTime::createFromFormat('Y-m-d', $year . '-' . $month . '-' . date('d'));
    }

    private function addDateDetailsToView()
    {
        $this->getDateDetails();
        $this->view->addToContextData('currentDate', $this->currentDate->format('Y-m'));
        $this->view->addToContextData('daysInMonth', $this->currentDate->format('t'));
        $this->view->addToContextData('currentMonth', $this->currentDate->format('n'));
    }
}
