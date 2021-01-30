<?php

namespace SM\Repos\EmployeesAffairs;

use SM\Entities\Employees\Employee;

interface EmployeeRepoInterface
{
    public function getById($id);
    public function getAll(): array;
}
