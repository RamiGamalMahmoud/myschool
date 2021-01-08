<?php

namespace SM\Repos\Exams\Sheets;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Entities\Exams\Sheets\MainSheetEntity;

class MainSheetRepo implements
    ISheetRepo
{
    protected IDataAccess $dataAccess;
    protected string $dbTable;
    protected int $gradeNumber;

    public function __construct(int $gradeNumber, IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->gradeNumber = $gradeNumber;
        $this->dbTable = 'main_sheet_degs';
    }

    function getAll(): array
    {
        return $this->getAllStudents();
    }

    function getById($id): array
    {
        return [];
    }

    public function getPassedStudents(): array
    {
        return $this->getAllStudents('PASSED');
    }

    public function getFailedStudents(): array
    {
        return $this->getAllStudents('FAILED');
    }

    private function getAllStudents(string $status = null)
    {
        $query = new Query();
        $query->select($this->getDBColumns())
            ->from($this->dbTable)
            ->where($this->dbTable . '.grade', '=', $this->gradeNumber);
        $data = $this->dataAccess->getAll($query);

        $fs_degs_settings = include_once FS_DEGS_SETTINGS;
        MainSheetEntity::setDegsSettings($fs_degs_settings);
        $entities = [];
        foreach ($data as $entity) {
            $student = new MainSheetEntity($entity);

            if ($status === null) {
                array_push($entities, $student);
            } elseif ($student->getStudentState()->getState() === $status) {
                array_push($entities, $student);
            }
        }
        return $entities;
    }

    private function getDBColumns()
    {
        $columns = require_once __DIR__ . DS . 'SSColumns.php';
        return $columns;
    }
}
