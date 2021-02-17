<?php

namespace SM\Repos\EmployeesAffairs;

use SM\Entities\Employees\Employee;

interface IEmployeeRepo
{
    public function getById($id);
    public function getAllIds(): array;
    public function getIdsWhere($name, $value);
    public function getAll(): array;
    public function filterBy($name, $value): array;
    public function update(Employee $employee);
}
