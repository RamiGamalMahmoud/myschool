<?php

namespace SM\Entities\StudentsAffairs;

class Student
{
    private $id;

    private $name;

    private $enrollmentStatus;

    private $religion;

    private $gender;

    private $nationalId;

    private $pirthdate;

    private $pirthDay;

    private $pirthMonth;

    private $pirthYear;

    private $classRoomId;

    public function __construct(
        $id,
        $name,
        $enrollmentStatus,
        $religion,
        $gender,
        $nationalId,
        $pirthdate,
        $pirthDay,
        $pirthMonth,
        $pirthYear,
        $classRoomId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->enrollmentStatus = $enrollmentStatus;
        $this->religion = $religion;
        $this->gender = $gender;
        $this->nationalId = $nationalId;
        $this->pirthdate = $pirthdate;
        $this->pirthDay = $pirthDay;
        $this->pirthMonth = $pirthMonth;
        $this->pirthYear = $pirthYear;
        $this->classRoomId = $classRoomId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEnrollmentStatus()
    {
        return $this->enrollmentStatus;
    }

    public function getReligion()
    {
        return $this->religion;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getNationalId()
    {
        return $this->nationalId;
    }

    public function getPirthdate()
    {
        return $this->pirthdate;
    }

    public function getPirthDay()
    {
        return $this->pirthDay;
    }

    public function getPirthMonth()
    {
        return $this->pirthMonth;
    }

    public function getPirthYear()
    {
        return $this->pirthYear;
    }

    public function getClassRoomId()
    {
        return $this->classRoomId;
    }
}
