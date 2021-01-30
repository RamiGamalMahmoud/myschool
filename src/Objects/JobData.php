<?php

namespace SM\Objects;

class JobData
{
    private ?string $dateOfHiring;

    private ?string $dateOfWorkReceived;

    private ?string $employeeType;

    private ?string $employeeStatus;

    private ?string $attitudeToWork;

    public function __construct($dateOfHiring, $dateOfWorkReceived, $employeeType, $employeeStatus, $attitudeToWork)
    {
        $this->dateOfHiring = $dateOfHiring;
        $this->dateOfWorkReceived = $dateOfWorkReceived;
        $this->employeeType = $employeeType;
        $this->employeeStatus = $employeeStatus;
        $this->attitudeToWork = $attitudeToWork;
    }

    public function getAttitudeToWork()
    {
        return $this->attitudeToWork;
    }

    public function getDateOfHiring()
    {
        return $this->dateOfHiring;
    }

    public function getDateOfWorkReceived()
    {
        return $this->dateOfWorkReceived;
    }

    public function getEmployeeType()
    {
        return $this->employeeType;
    }

    public function getEmployeeStatus()
    {
        return $this->employeeStatus;
    }

    public function toArray(): array
    {
        return [
            'date-of-hiring' => $this->getDateOfHiring(),
            'date-of-work-received' => $this->getDateOfWorkReceived(),
            'employee-type' => $this->getEmployeeType(),
            'employee-status' => $this->getEmployeeStatus(),
            'attitude-to-work' => $this->getAttitudeToWork()
        ];
    }
}
