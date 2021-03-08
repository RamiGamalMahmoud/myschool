<?php

namespace SM\Repos\Timetable;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Entities\Timetable\Period;
use SM\Repos\BaseRepo;

class PeriodRepo extends BaseRepo implements IPeriodRepo
{
    public function __construct(IDataAccess $dataAccess)
    {
        parent::__construct($dataAccess, 'period');
    }

    public function getAllPeriods(): array
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->orderBy(['number' => 'ASC']);
        $data = $this->dataAccess->getAll($query);
        return array_map(function ($period) {
            return new Period($period['id'], $period['number'], $period['start'], $period['end']);
        }, $data);
    }

    public function getPeriods(int $count)
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->orderBy(['number' => 'ASC'])
            ->limit($count);
        $data = $this->dataAccess->getAll($query);
        return array_map(function ($period) {
            return new Period($period['id'], $period['number'], $period['start'], $period['end']);
        }, $data);
    }

    public function getPeriodById($id): Period
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->orderBy(['number' => 'ASC'])
            ->where('id', '=', $id);
        $period = $this->dataAccess->get($query);
        return new Period($period['id'], $period['number'], $period['start'], $period['end']);
    }
}
