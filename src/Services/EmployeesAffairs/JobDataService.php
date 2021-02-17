<?php

namespace SM\Services\EmployeesAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use SM\Entities\EmployeesAffairs\EmployeeStatus;
use SM\Repos\EmployeesAffairs\JobData\AttitudeToWorkRepo;
use SM\Repos\EmployeesAffairs\JobData\EmployeeStatusRepo;
use SM\Repos\EmployeesAffairs\JobData\IAttitudeToWorkRepo;
use SM\Repos\EmployeesAffairs\JobData\IEmployeeStatusRepo;
use SM\Repos\EmployeesAffairs\JobData\IPresenceStatusRepo;
use SM\Repos\EmployeesAffairs\JobData\PresenceStatusRepo;

class JobDataService
{
    private IAttitudeToWorkRepo $attitudeToWorkRepo;

    private IPresenceStatusRepo $presenceStatusRepo;

    private IEmployeeStatusRepo $employeeStatusRepo;

    public function __construct()
    {
        $dataAccess = new MySQLAccess();
        $this->attitudeToWorkRepo = new AttitudeToWorkRepo($dataAccess);
        $this->presenceStatusRepo = new PresenceStatusRepo($dataAccess);
        $this->employeeStatusRepo = new EmployeeStatusRepo($dataAccess);
    }

    public function getAllAttitudes()
    {
        return $this->attitudeToWorkRepo->getAll();
    }

    public function getAllPresenceStatus()
    {
        return $this->presenceStatusRepo->getAll();
    }
}
