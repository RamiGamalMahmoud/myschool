<?php

namespace SM\Repos\Exams\Sheets;

use Simple\Core\DataAccess\Query;
use Simple\Core\DataAccess\IDataAccess;
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
    public function getAll()
    {
        $query = new Query();
        $query->select($this->getDBColumns())
            ->from($this->dbTable)
            ->where($this->dbTable . '.grade', '=', $this->gradeNumber);
        $data = $this->dataAccess->getAll($query);
        $fs_degs_settings = include_once FS_DEGS_SETTINGS;
        FirstSemesterSheetEntity::setDegsSettings($fs_degs_settings);
        $entities = [];
        $entities = array_map(function ($entity) use ($fs_degs_settings) {
            return new FirstSemesterSheetEntity($entity);
        }, $data);

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
