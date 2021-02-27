<?php

namespace SM\Services\StudentsAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Helpers\Log;
use SM\Repos\StudentsAffairs\IStudentRepo;
use SM\Repos\StudentsAffairs\StudentRepo;

class StudentService
{
    private IStudentRepo $studentRepo;

    public function __construct()
    {
        $this->studentRepo = new StudentRepo(new MySQLAccess());
    }

    public function getAllStudents()
    {
        return $this->studentRepo->getAll();
    }

    public function getStudentsByGradeNumber(int $gradeNumber)
    {
        return $this->studentRepo->getByGradeNumber($gradeNumber);
    }

    public function getStudentsByClassNumber(int $gradeNumber, int $classNumber)
    {
        return $this->studentRepo->getByClassNumber($gradeNumber, $classNumber);
    }
}
