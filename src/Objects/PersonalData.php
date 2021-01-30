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

    public function __construct($name, $nationalId, $pirthdate, $gender, $religion, $nationality)
    {
        $this->name        = $name;
        $this->nationalId  = $nationalId;
        $this->pirthdate   = $pirthdate;
        $this->gender      = $gender;
        $this->religion    = $religion;
        $this->nationality = $nationality;
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

    public function toArray()
    {
        return [
            'name' => $this->getName(),
            'national-id' => $this->getNationalId(),
            'pirthdate' => $this->getPirthdate(),
            'gender' => $this->getGender(),
            'religion' => $this->getReligion(),
            'nationality' => $this->getNationality()
        ];
    }
}
