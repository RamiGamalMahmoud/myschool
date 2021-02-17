<?php

namespace SM\Repos\EmployeesAffairs;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Helpers\Log;
use SM\Builders\PersonBuilder;
use SM\Entities\Employees\Employee;

class EmployeeRepo implements IEmployeeRepo
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
    private array $columns = [
        'id',
        'name',
        'national_id',
        'pirthdate',
        'gender',
        'religion',
        'nationality',
        'employee_type',
        'date_of_hiring',
        'date_of_work_received',
        'fixed_phone',
        'mobile',
        'governorate_name',
        'governorate_id ',
        'city_name',
        'city_id ',
        'district',
        'street',
        'code',
        'insurance_number'
    ];

    /**
     * Constructor
     */
    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->table = 'employee_view';
    }

    public function getById($id)
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->where('id', '=', $id);
        $employee = $this->dataAccess->get($query);
        return PersonBuilder::makeEmployeeObject($employee);
    }

    public function getAll(): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)

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
            ->from('employee_view')

            ->where($name, '=', $value)
            ->orderBy(['name']);
        $data = $this->dataAccess->getAll($query);
        $employees = array_map(function ($employee) {
            return PersonBuilder::makeEmployeeObject($employee);
        }, $data);
        return $employees;
    }

    public function getAllIds(): array
    {
        $query = new Query();
        $query->select(['id'])
            ->from('employee')
            ->orderBy(['id']);
        return $this->dataAccess->getAll($query);
    }

    public function update(Employee $employee)
    {
        
    }
}
