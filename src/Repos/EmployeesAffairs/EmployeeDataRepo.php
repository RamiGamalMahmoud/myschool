<?php

namespace SM\Repos\EmployeesAffairs;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;

class EmployeeDataRepo implements IEmployeeDataRepo
{
    private IDataAccess $dataAccess;

    private string $table = 'employee_view';

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getAll()
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->orderBy(['name']);
        return $this->dataAccess->getAll($query);
    }

    public function getById($id)
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->where('id', '=', $id);
        return $this->dataAccess->get($query);
    }

    public function gitBy($key, $value)
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->where($key, '=', $value)
            ->orderBy(['name']);
        return $this->dataAccess->getAll($query);
    }
}
