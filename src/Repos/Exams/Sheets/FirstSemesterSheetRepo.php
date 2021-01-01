<?php

namespace SM\Repos\Exams\Sheets;

use Simple\Core\DataAccess\Query;
use Simple\Core\DataAccess\IDataAccess;
use Simple\Helpers\Functions;
use SM\Entities\Exams\Sheets\FirstSemesterSheetEntity;

class FirstSemesterSheetRepo implements IFirstSemesterSheetRepo
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

    /**
     * Get All Data from the data source
     * @return array
     */
    public function getAll(): array
    {
        return $this->getAllStudents();
    }

    /**
     * Get one data item from data source
     */
    public function getById($id): array
    {
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
            ->where($this->dbTable . '.grade', '=', $this->gradeNumber)->limit(1);
        $data = $this->dataAccess->getAll($query);
        $fs_degs_settings = include_once FS_DEGS_SETTINGS;
        FirstSemesterSheetEntity::setDegsSettings($fs_degs_settings);
        $entities = [];
        foreach ($data as $entity) {
            $student = new FirstSemesterSheetEntity($entity);
            if ($status === null) {
                array_push($entities, $student);
            } elseif ($student->getStudentState()->getState() === $status) {
                array_push($entities, $student);
            }
        };
        return $entities;
    }

    private function getDBColumns()
    {
        return require_once __DIR__ . DS . 'FSColumns.php';
    }
}
