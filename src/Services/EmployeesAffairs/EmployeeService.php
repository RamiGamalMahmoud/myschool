<?php

namespace SM\Services\EmployeesAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Helpers\Log;
use SM\Builders\PersonBuilder;
use SM\Entities\Employees\Employee;
use SM\Entities\EmployeesAffairs\EmployeeStatus;
use SM\Entities\EmployeesAffairs\SocialStatus;
use SM\Repos\EmployeesAffairs\EmployeeDataRepo;
use SM\Repos\EmployeesAffairs\EmployeeRepo;
use SM\Repos\EmployeesAffairs\IEmployeeDataRepo;
use SM\Repos\EmployeesAffairs\IEmployeeRepo;
use SM\Repos\EmployeesAffairs\JobData\EmployeeStatusRepo;
use SM\Repos\EmployeesAffairs\JobData\IEmployeeStatusRepo;
use SM\Repos\EmployeesAffairs\SocialData\ISocialStatusRepo;
use SM\Repos\EmployeesAffairs\SocialData\SocialStatusRepo;

class EmployeeService
{
    private IEmployeeRepo $employeeRepo;

    private IEmployeeDataRepo $employeeDataRepo;

    private IEmployeeStatusRepo $employeeStatusRepo;

    private ISocialStatusRepo $socialStatusRepo;

    public function __construct()
    {
        $dataAccess = new MySQLAccess();
        $this->employeeRepo = new EmployeeRepo($dataAccess);
        $this->employeeDataRepo = new EmployeeDataRepo($dataAccess);
        $this->employeeStatusRepo = new EmployeeStatusRepo($dataAccess);
        $this->socialStatusRepo = new SocialStatusRepo($dataAccess);
    }

    public function getAllByIds(array $ids)
    {
        $employees = array_map(function ($id) {
            return $this->getById($id['id']);
        }, $ids);
        return $employees;
    }

    public function getAll()
    {
        $data = $this->employeeDataRepo->getAll();
        $employees = array_map(function ($item) {
            return $this->prepareData($item);
        }, $data);
        return $employees;
    }

    public function prepareData($data)
    {
        return [
            'employee' => PersonBuilder::makeEmployeeObject($data),
            'employee-status' => new EmployeeStatus(
                $data['last_employee_status_id'],
                $data['id'],
                $data['attitude_to_work_id'],
                $data['attitude_to_work'],
                $data['presence_status_id'],
                $data['presence_status'],
                $data['last_employee_status_update_date']
            ),
            'social-status' => new SocialStatus(
                $data['last_social_status_id'],
                $data['id'],
                $data['martial_status'],
                $data['martial_status_id'],
                $data['children_count'],
                $data['last_social_status_update_date']
            )
        ];
    }

    public function getById($id)
    {
        return $this->prepareData($this->employeeDataRepo->getById($id));
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

    public function filterBy($filterType, $criteria, $value): array
    {
        return array_map(function ($employee) {
            return $this->prepareData($employee);
        }, $this->employeeDataRepo->gitBy($criteria, $value));
    }
}
