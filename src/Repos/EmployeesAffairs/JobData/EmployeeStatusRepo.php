<?php

namespace SM\Repos\EmployeesAffairs\JobData;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Helpers\Log;
use SM\Entities\EmployeesAffairs\EmployeeStatus;

class EmployeeStatusRepo implements IEmployeeStatusRepo
{
    private IDataAccess $dataAccess;

    private string $view = 'employee_status_view';

    private string $table = 'employee_status';

    private array $columns = [
        'id',
        'employee_id',
        'attitude_to_work_id',
        'attitude_to_work',
        'presence_status_id',
        'presence_status',
        'date'
    ];

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getByEmployeeId($employeeId): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->view)
            ->where('employee_id', '=', $employeeId)
            ->orderBy(['date' => 'DESC']);
        $data = $this->dataAccess->getAll($query);
        $employeeStatuses = array_map(function ($status) {
            return new EmployeeStatus(
                $status['id'],
                $status['employee_id'],
                $status['attitude_to_work_id'],
                $status['attitude_to_work'],
                $status['presence_status_id'],
                $status['presence_status'],
                $status['date']
            );
        }, $data);
        return $employeeStatuses;
    }

    public function getLastEmployeeStatus($employeeId): EmployeeStatus
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->view)
            ->where('employee_id', '=', $employeeId)
            ->orderBy(['date' => 'DESC'])
            ->limit(1);
        $data = $this->dataAccess->get($query);
        return new EmployeeStatus(
            $data['id'],
            $data['employee_id'],
            $data['attitude_to_work_id'],
            $data['attitude_to_work'],
            $data['presence_status_id'],
            $data['presence_status'],
            $data['date']
        );
    }

    public function create(EmployeeStatus $employeeStatus)
    {
        $data = [
            'id' => null,
            'employee_id' => $employeeStatus->getEmployeeId(),
            'attitude_to_work_id' => $employeeStatus->getAttitudeToWorkId(),
            'presence_status_id ' => $employeeStatus->getPresenceStatusId(),
            'date' => $employeeStatus->getUpdateDate()
        ];
        $query = new Query();
        $query->insertInto($this->table)
            ->values($data);
        return $this->dataAccess->run($query);
    }

    public function isRecordExists(EmployeeStatus $employeeStatus)
    {
        $query = new Query();
        $query->select(['id'])
            ->from($this->table)
            ->where('employee_id', '=', $employeeStatus->getEmployeeId())
            ->andWhere('attitude_to_work_id', '=', $employeeStatus->getAttitudeToWorkId())
            ->andWhere('presence_status_id', '=', $employeeStatus->getPresenceStatusId());
        $result = $this->dataAccess->get($query);
        return $result !== false;
    }
}
