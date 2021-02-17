<?php

namespace SM\Services\EmployeesAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Helpers\Log;
use SM\Entities\Employees\Employee;
use SM\Entities\EmployeesAffairs\EmployeeStatus;
use SM\Entities\EmployeesAffairs\SocialStatus;
use SM\Repos\EmployeesAffairs\EmployeeRepo;
use SM\Repos\EmployeesAffairs\IEmployeeRepo;
use SM\Repos\EmployeesAffairs\JobData\EmployeeStatusRepo;
use SM\Repos\EmployeesAffairs\JobData\IEmployeeStatusRepo;
use SM\Repos\EmployeesAffairs\SocialData\ISocialStatusRepo;
use SM\Repos\EmployeesAffairs\SocialData\SocialStatusRepo;

class EmployeeService
{
    private IEmployeeRepo $employeeRepo;

    private IEmployeeStatusRepo $employeeStatusRepo;

    private ISocialStatusRepo $socialStatusRepo;

    public function __construct()
    {
        $dataAccess = new MySQLAccess();
        $this->employeeRepo = new EmployeeRepo($dataAccess);
        $this->employeeStatusRepo = new EmployeeStatusRepo($dataAccess);
        $this->socialStatusRepo = new SocialStatusRepo($dataAccess);
    }

    public function getAll()
    {
        $ids = $this->employeeRepo->getAllIds();
        $employees = array_map(function ($id) {
            return $this->getById($id['id']);
        }, $ids);
        return $employees;
    }

    public function getById($id)
    {
        return [
            'employee' => $this->employeeRepo->getById($id),
            'employee-status' => $this->employeeStatusRepo->getLastEmployeeStatus($id),
            'social-status' => $this->socialStatusRepo->getLastEmployeeStatus($id)
        ];
    }

    public function saveEmployee(
        Employee $employee,
        EmployeeStatus $employeeStatus,
        bool $isEmployeeStatusDirty,
        SocialStatus $socialStatus,
        bool $isSocialStatusDirty
    ) {
        $this->employeeRepo->update($employee);

        if ($isEmployeeStatusDirty) {
            $this->employeeStatusRepo->create($employeeStatus);
        }

        if ($isSocialStatusDirty) {
            $this->socialStatusRepo->create($socialStatus);
        }
    }
}
