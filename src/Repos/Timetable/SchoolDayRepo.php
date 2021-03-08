<?php

namespace SM\Repos\Timetable;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Repos\BaseRepo;

class SchoolDayRepo extends BaseRepo implements ISchoolDayRepo
{
    public function __construct(IDataAccess $dataAccess)
    {
        parent::__construct($dataAccess, 'workday');
    }

    public function getAllDays()
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->where($this->table . '.periods_count', '>', '0');
        $data = $this->dataAccess->getAll($query);
        return $data;
    }
}
