<?php

namespace SM\Repos\EmployeesAffairs\JobData;

use SM\Entities\EmployeesAffairs\EmployeeStatus;

interface IEmployeeStatusRepo
{
    public function getByEmployeeId($employeeId): array;
    public function create(EmployeeStatus $employeeStatus);
    public function isRecordExists(EmployeeStatus $employeeStatus);
}
