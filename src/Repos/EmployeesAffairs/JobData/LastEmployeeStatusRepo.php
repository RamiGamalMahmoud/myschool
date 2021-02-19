<?php

namespace SM\Repos\EmployeesAffairs\JobData;

use Exception;
use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Helpers\Log;
use SM\Entities\EmployeesAffairs\EmployeeStatus;

class LastEmployeeStatusRepo implements ILastEmployeeStatusRepo
{
    private IDataAccess $dataAccess;

    private string $table = 'last_employee_status';

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function update(EmployeeStatus $employeeStatus)
    {
        $query = new Query();
        $query->update($this->table)
            ->set([
                $this->table . '.attitude_to_work_id' => $employeeStatus->getAttitudeToWorkId(),
                $this->table . '.presence_status_id' => $employeeStatus->getPresenceStatusId(),
                $this->table . '.update_date' => $employeeStatus->getUpdateDate()
            ])
            ->where($this->table . '.employee_id', '=', $employeeStatus->getEmployeeId());
        return $this->dataAccess->run($query);
    }

    public function create(EmployeeStatus $employeeStatus)
    {
        throw new Exception('method not implemented yet');
    }
}
