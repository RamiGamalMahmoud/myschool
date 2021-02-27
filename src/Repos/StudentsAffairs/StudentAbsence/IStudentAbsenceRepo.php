<?php

namespace SM\Repos\StudentsAffairs\StudentAbsence;

interface IStudentAbsenceRepo
{
    public function getAll(string $date): array;
    public function getByGrade(string $yearMonth, int $gradeNumber): array;
    public function getByClass(string $yearMonth, int $gradeNumber, int $classNumber): array;
    public function registerAbsence($studentId, $date);
    public function isRegistered($studentId, $date);
    public function removeRegisteredAbsence($studentId, $date);
}
