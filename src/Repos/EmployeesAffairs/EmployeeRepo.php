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
    private array $columns = ['employees.id', 'name', 'national_id', 'pirthdate', 'district', 'date_of_hiring', 'date_of_work_received', 'gender', 'religion', 'martial_status', 'children_count', 'nationality', 'employee_status', 'employee_type', 'attitude_to_work', 'fixed_phone', 'mobile', 'employees.governorate_id', 'city_id', 'city_name', 'governorate_name'];

    /**
     * Constructor
     */
    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->table = 'employees';
    }

    public function getById($id)
    {
        return $this->getAll();
    }

    public function getAll(): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->join('cities')
            ->on($this->table . '.city_id', 'cities.id')
            ->join('governorates')
            ->on($this->table . '.governorate_id', 'governorates.id');
        $data = $this->dataAccess->getAll($query);
        $employees = array_map(function ($employee) {
            return PersonBuilder::makeEmployeeObject($employee);
        }, $data);
        return $employees;
    }
}
