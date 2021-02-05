<?php

namespace SM\Repos\EmployeesAffairs;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Builders\PersonBuilder;
use SM\Entities\Employees\Employee;

class EmployeeRepo implements EmployeeRepoInterface
{
    /**
     * @var \Simple\Core\DataAccess\IDataAccess $dataAccess
     */
    private IDataAccess $dataAccess;

    /**
     * @var string $table
     */
    private string $table;

    /**
     * @var array $columns
     */
    private array $columns = [];

    /**
     * Constructor
     */
    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->columns = require_once __DIR__ . DS . 'employee-table-columns.php';
        $this->table = 'employees';
    }

    public function getById($id)
    {
        $query = new Query();
        $query->select($this->columns)
            ->from('employee_view')
            ->where('id', '=', $id);
        $employee = $this->dataAccess->get($query);
        return PersonBuilder::makeEmployeeObject($employee);
    }

    public function getAll(): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from('employee_view')

            ->orderBy(['name']);
        $data = $this->dataAccess->getAll($query);
        $employees = array_map(function ($employee) {
            return PersonBuilder::makeEmployeeObject($employee);
        }, $data);
        return $employees;
    }

    /**
     * Search employees by criteria
     * 
     * @param string $filterName
     * @param string $filterValue
     */
    public function filterBy($name, $value): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->join('city')
            ->on($this->table . '.city_id', 'city.id')
            ->join('governorate')
            ->on($this->table . '.governorate_id', 'governorate.id')
            ->where($name, '=', $value)
            ->orderBy([$this->table . '.name']);
        $data = $this->dataAccess->getAll($query);
        $employees = array_map(function ($employee) {
            return PersonBuilder::makeEmployeeObject($employee);
        }, $data);
        return $employees;
    }
}
