<?php

namespace SM\Entities\EmployeesAffairs;

class SocialStatus
{
    private $employeeId;

    private $martialStatus;

    private $martialStatusId;

    private $childrenCount;

    private $updateDate;

    public function __construct(
        $employeeId,
        $martialStatus,
        $martialStatusId,
        $childrenCount,
        $updateDate
    ) {
        $this->employeeId = $employeeId;
        $this->martialStatus = $martialStatus;
        $this->martialStatusId = $martialStatusId;
        $this->childrenCount = $childrenCount;
        $this->updateDate = $updateDate;
    }

    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function getMartialStatusId()
    {
        return $this->martialStatusId;
    }

    public function getMartialStatus()
    {
        return $this->martialStatus;
    }

    public function getChildrenCount()
    {
        return $this->childrenCount;
    }

    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    public function toArray()
    {
        return [
            'martial-status' => $this->getMartialStatus(),
            'children-count' => $this->getChildrenCount()
        ];
    }
}
