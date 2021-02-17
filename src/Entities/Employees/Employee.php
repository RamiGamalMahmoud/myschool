<?php

namespace SM\Entities\Employees;

use SM\Objects\Address\Address;
use SM\Objects\JobData;
use SM\Objects\PersonalData;
use SM\Objects\Phone;
use SM\Objects\SocialData;

class Employee
{
    private $id;

    private PersonalData $personalData;

    private Address $address;

    private Phone $phone;

    public function __construct(
        $id,
        PersonalData $personalData,
        Address $address,
        Phone $phone
    ) {
        $this->id = $id;
        $this->personalData = $personalData;
        $this->address = $address;
        $this->phone = $phone;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPersonalData(): PersonalData
    {
        return $this->personalData;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'personal-data' => $this->getPersonalData()->toArray(),
            'address' => $this->getAddress()->toArray(),
            'phone' => $this->getPhone()->toArray()
        ];
    }
}
