<?php

namespace SM\Repos\EmployeesAffairs\JobData;

use SM\Entities\EmployeesAffairs\EmployeeStatus;

interface ILastEmployeeStatusRepo
{
    public function update(EmployeeStatus $employeeStatus);
    public function create(EmployeeStatus $employeeStatus);
}
