<?php

namespace SM\Repos\StudentsAffairs;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Entities\StudentsAffairs\Grade;

class GradeRepo implements IGradeRepo
{
    private IDataAccess $dataAccess;

    private string $table = 'grade';

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getAll(): ?array
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->orderBy(['grade_number']);
        $data = $this->dataAccess->getAll($query);
        $grades = array_map(function ($grade) {
            return new Grade($grade['id'], $grade['grade_number'], $grade['grade_name']);
        }, $data);
        return $grades;
    }
}
