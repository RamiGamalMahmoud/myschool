<?php

namespace SM\Entities\EmployeesAffairs;

class EmployeeStatus
{
    private $id;

    private $employeeId;

    private $attitudeToWorkId;

    private $attitudeToWork;

    private $presenceStatusId;

    private $presenceStatus;

    private $updateDate;

    public function __construct(
        $id,
        $employeeId,
        $attitudeToWorkId,
        $attitudeToWork,
        $presenceStatusId,
        $presenceStatus,
        $updateDate
    ) {
        $this->id = $id;
        $this->employeeId = $employeeId;
        $this->attitudeToWorkId = $attitudeToWorkId;
        $this->attitudeToWork = $attitudeToWork;
        $this->presenceStatusId = $presenceStatusId;
        $this->presenceStatus = $presenceStatus;
        $this->updateDate = $updateDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function getAttitudeToWorkId()
    {
        return $this->attitudeToWorkId;
    }

    public function getAttitudeToWork()
    {
        return $this->attitudeToWork;
    }

    public function getPresenceStatusId()
    {
        return $this->presenceStatusId;
    }

    public function getPresenceStatus()
    {
        return $this->presenceStatus;
    }

    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    public function toArray()
    {
        return [
            'presence-status' => $this->getPresenceStatus(),
            'attitude-to-work' => $this->getAttitudeToWork()
        ];
    }
}
