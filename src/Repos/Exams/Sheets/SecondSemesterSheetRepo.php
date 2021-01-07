<?php

namespace SM\Repos\Exams\Sheets;

use Simple\Core\DataAccess\IDataAccess;

class SecondSemesterSheetRepo implements
    ISheetRepo
{
    protected IDataAccess $dataAccess;
    protected string $dbTable;
    protected int $gradeNumber;

    public function __construct(string $semester, int $gradeNumber, IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->gradeNumber = $gradeNumber;
        $this->dbTable = $semester . '_degs';
    }

    function getAll(): array
    {
        return [];
    }

    function getById($id): array
    {
        return [];
    }

    public function getPassedStudents(): array
    {
        return [];
    }

    public function getFailedStudents(): array
    {
        return [];
    }

    private function getDBColumns()
    {
        return require_once __DIR__ . DS . 'SSColumns.php';
    }
}
