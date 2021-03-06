<?php

namespace SM\Repos\Timetable;

use Simple\Core\DataAccess\IDataAccess;
use SM\Repos\BaseRepo;

class TimetableRepo extends BaseRepo implements ITimetableRepo
{
    public function __construct(IDataAccess $dataAccess)
    {
        parent::__construct($dataAccess, '');
    }
}
