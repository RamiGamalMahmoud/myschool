<?php

namespace SM\Repos\StudentsAffairs;

use SM\Entities\StudentsAffairs\Student;

interface IStudentRepo
{
    function getAll(): array;
    public function getByGradeNumber(int $gradeNumber): array;
    public function getByClassNumber(int $gradeNumber, int $classNumber): array;
    public function getById(): Student;
    // function create(Student $student);
    // function edit(Student $student);
    // function getById($id): Student;
    // function remove($id);
}
