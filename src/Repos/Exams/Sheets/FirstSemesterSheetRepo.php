<?php

namespace SM\Repos\Exams\Sheets;

use SM\Repos\IReadRepo;
use SM\Entities\Entity;
use Simple\Core\DataAccess\Query;
use Simple\Core\DataAccess\IDataAccess;
use Simple\Helpers\Functions;
use SM\Entities\Exams\Sheets\FirstSemesterEntity;

class FirstSemesterSheetRepo implements IReadRepo
{

    protected IDataAccess $dataAccess;
    protected string $dbTable;
    protected int $gradeNumber;

    public function __construct(string $semester, int $gradeNumber, IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->gradeNumber = $gradeNumber;
        $this->dbTable = $semester . '_sheet_view';
    }

    /**
     * Get All Data from the data source
     */
    public function getAll()
    {
        $query = new Query();
        $query->select($this->getDBColumns())
            ->from($this->dbTable)
            ->where($this->dbTable . '.grade', '=', $this->gradeNumber);
        $data = $this->dataAccess->getAll($query);
        $entities = [];
        foreach ($data as $entity) {
            array_push($entities, new FirstSemesterEntity($entity));
        }

        return $entities;
    }

    /**
     * Get one data item from data source
     */
    public function getById($id)
    {
    }

    private function getDBColumns()
    {
        return require_once __DIR__ . DS . 'FSColumns.php';
    }
}
