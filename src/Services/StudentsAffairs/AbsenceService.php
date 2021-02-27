<?php

namespace SM\Services\StudentsAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\StudentsAffairs\StudentAbsence\IStudentAbsenceRepo;
use SM\Repos\StudentsAffairs\StudentAbsence\StudentAbsenceRepo;
use SM\Services\StudentsAffairs\StudentService;

class AbsenceService
{
    private IStudentAbsenceRepo $studentAbsenceRepo;

    public function __construct()
    {
        $this->studentAbsenceRepo = new StudentAbsenceRepo(new MySQLAccess());
    }

    public function getAll(string $date)
    {
        return $this->studentAbsenceRepo->getAll($date);
    }

    public function getByGrade($yearMonth, int $gradeNumber)
    {
        return $this->studentAbsenceRepo->getByGrade($yearMonth, $gradeNumber);
    }

    public function getByClass($yearMonth, int $gradeNumber, int $classNumber)
    {
        return $this->studentAbsenceRepo->getByClass($yearMonth, $gradeNumber, $classNumber);
    }

    public function registerAbsence($studentId, $date)
    {
        if (!$this->studentAbsenceRepo->isRegistered($studentId, $date)) {
            return $this->studentAbsenceRepo->registerAbsence($studentId, $date);
        } else {
            return $this->studentAbsenceRepo->removeRegisteredAbsence($studentId, $date);
        }
    }

    public function checkIfStudentRegistered($studentId, $date)
    {
        return $this->studentAbsenceRepo->isRegistered($studentId, $date);
    }
}
