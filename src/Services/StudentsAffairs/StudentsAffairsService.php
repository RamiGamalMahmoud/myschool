<?php

namespace SM\Services\StudentsAffairs;

use Simple\Helpers\Log;
use SM\Services\StudentsAffairs\StudentService;

class StudentsAffairsService
{
    private GradeService $gradeService;

    private ClassRoomService $classRoomService;

    private StudentService $studentService;

    public function __construct()
    {
        $this->gradeService = new GradeService();
        $this->classRoomService = new ClassRoomService();
        $this->studentService = new StudentService();
    }

    public function getGrades()
    {
        return $this->gradeService->getGrades();
    }

    public function getClassRooms()
    {
        return $this->classRoomService->getClassRooms();
    }

    public function getAllStudents()
    {
        return $this->studentService->getAllStudents();
    }

    public function getStudentsByGradeNumber(int $gradeNumber)
    {
        return $this->studentService->getStudentsByGradeNumber($gradeNumber);
    }

    public function getStudentsByClassNumber(int $gradeNumber, int $classNumber)
    {
        return $this->studentService->getStudentsByClassNumber($gradeNumber, $classNumber);
    }
}
