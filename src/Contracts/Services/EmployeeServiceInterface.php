<?php

namespace SM\Contracts\Services;

use SM\Entities\Employees\Employee;
use SM\Entities\EmployeesAffairs\EmployeeStatus;
use SM\Entities\EmployeesAffairs\SocialStatus;

interface EmployeeServiceInterface
{
    public function getAllByIds(array $ids);
    public function getByEmployeeName(string $employeeName);
    public function getAll();
    public function getPresentEmployees();
    public function prepareData($data);
    public function getById($id);
    public function saveEmployee(
        Employee $employee,
        EmployeeStatus $employeeStatus,
        bool $isEmployeeStatusDirty,
        SocialStatus $socialStatus,
        bool $isSocialStatusDirty
    );
    public function filterBy($filterType, $criteria, $value): array;
}
