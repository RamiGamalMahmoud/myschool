<?php

namespace SM\Services\StudentsAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\StudentsAffairs\GradeRepo;
use SM\Repos\StudentsAffairs\IGradeRepo;

class GradeService
{
    private IGradeRepo $gradeRepo;

    public function __construct()
    {
        $this->gradeRepo = new GradeRepo(new MySQLAccess());
    }

    public function getGrades()
    {
        return $this->gradeRepo->getAll();
    }
}
