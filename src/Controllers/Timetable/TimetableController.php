<?php

namespace SM\Controllers\Timetable;

use Simple\Core\Redirect;
use Simple\Core\Request;
use Simple\Core\Router;
use SM\Controllers\BaseController;
use SM\Services\StudentsAffairs\ClassRoomService;
use SM\Services\StudentsAffairs\GradeService;
use SM\Services\Timetable\TeacherService;
use SM\Services\Timetable\TimetableService;
use SM\Views\Timetable\TimetableView;

class TimetableController extends BaseController
{
    private TimetableView $view;

    private TimetableService $timetableService;

    private TeacherService $teacherService;


    private function getGradesData()
    {
        $classroomService = new ClassRoomService();
        $gradeService = new GradeService();
        $classrooms = $classroomService->getClassRooms();
        $grades = $gradeService->getGrades();
        $gradeClassrooms = [];

        foreach ($grades as $grade) {
            $classroomsInGrade = array_filter($classrooms, function ($classroom) use ($grade) {
                return ($classroom->getGradeNumber() === $grade->getGradeNumber());
            });
            $gradeClassrooms[$grade->getGradeNumber()] = ['name' => $grade->getGradeName(), 'classrooms' => $classroomsInGrade];
        }

        return $gradeClassrooms;
    }

    public function __construct(Request $request, Router $router)
    {
        parent::__construct($request, $router);
        $this->timetableService = new TimetableService();
        $this->teacherService = new TeacherService();
        $this->view  = new TimetableView();
    }

    public function index()
    {
        $this->view->render();
    }

    public function showTeacherTable()
    {
        $this->view->showTeachersTable(
            $this->teacherService->getAllTeachers(),
            $this->getGradesData()
        );
    }

    public function updateTeacher()
    {
        $classrooms = $this->request->input('classrooms');
        $teacherId = $this->request->input('teacher-id');
        $this->teacherService->updateTeacherClassrooms($teacherId, $classrooms);
        Redirect::to('/timetable/teacher-table');
    }

    public function editTeacherClassrooms()
    {
        $id = $this->router->get('id');
        $teacher = $this->teacherService->getTeacher($id);
        $this->view->addToContextData('grades', $this->getGradesData());
        $this->view->showEditTeacherForm($teacher);
    }
}
