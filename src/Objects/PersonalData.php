<?php

namespace SM\Objects;

class PersonalData
{
    private string $name;

    private string $nationalId;

    private string $pirthdate;

    private string $gender;

    private string $religion;

    private string $nationality;

    private $employee_type;

    private $date_of_hiring;

    private $date_of_work_received;

    public function __construct(
        $name,
        $nationalId,
        $pirthdate,
        $gender,
        $religion,
        $nationality,
        $employee_type,
        $date_of_hiring,
        $date_of_work_received
    ) {
        $this->name                  = $name;
        $this->nationalId            = $nationalId;
        $this->pirthdate             = $pirthdate;
        $this->gender                = $gender;
        $this->religion              = $religion;
        $this->nationality           = $nationality;
        $this->employee_type         = $employee_type;
        $this->date_of_hiring        = $date_of_hiring;
        $this->date_of_work_received = $date_of_work_received;
    }

    public function getName()
    {
        return $this->name;
    }
    public function getNationalId()
    {
        return $this->nationalId;
    }
    public function getPirthdate()
    {
        return $this->pirthdate;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getReligion()
    {
        return $this->religion;
    }

    public function getNationality()
    {
        return $this->nationality;
    }

    public function getEmployeeType()
    {
        return $this->employee_type;
    }

    public function getDateOfHiring()
    {
        return $this->date_of_hiring;
    }

    public function getDateOfWorkReceived()
    {
        return $this->date_of_work_received;
    }


    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'national-id' => $this->getNationalId(),
            'pirthdate' => $this->getPirthdate(),
            'gender' => $this->getGender(),
            'religion' => $this->getReligion(),
            'nationality' => $this->getNationality(),
            'employee-type' => $this->getEmployeeType(),
            'date-of-hiring' => $this->getDateOfHiring(),
            'date-of-work-received' => $this->getDateOfWorkReceived()
        ];
    }
}
