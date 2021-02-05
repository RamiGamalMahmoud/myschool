<?php

namespace SM\Builders;

use SM\Entities\Employees\Employee;
use SM\Objects\Phone;
use SM\Objects\SocialData;
use SM\Objects\Address\City;
use SM\Objects\PersonalData;
use SM\Objects\Address\Address;
use SM\Objects\Address\Governorate;
use SM\Objects\JobData;

class PersonBuilder
{
    private static array $data;

    public static function setData(array $data)
    {
        self::$data = $data;
    }

    public static function makeEmployeeObject(array $data): Employee
    {
        self::setData($data);
        $id = self::$data['id'];
        $personalData = self::makePersonalDataObject();
        $socialData = self::makeSocialDataObject();
        $jobData = self::makeJobDataObject();
        $address = self::makeAddressObject();
        $phone = self::makePhoneObject();
        $employee = new Employee($id, $personalData, $socialData, $jobData, $address, $phone);
        return $employee;
    }

    private static function makeJobDataObject(): JobData
    {
        $dateOfHiring = self::$data['date_of_hiring'];
        $dateOfWorkReceived = self::$data['date_of_work_received'];
        $employeeType = self::$data['employee_type'];
        $employeeStatus = self::$data['employee_status'];
        $attitudeToWork = self::$data['attitude_to_work'];
        $jobData = new JobData($dateOfHiring, $dateOfWorkReceived, $employeeType, $employeeStatus, $attitudeToWork);
        return $jobData;
    }

    private static function makePersonalDataObject(): PersonalData
    {
        $name        = self::$data['name'];
        $nationalId  = self::$data['national_id'];
        $pirthdate   = self::$data['pirthdate'];
        $gender      = self::$data['gender'];
        $religion    = self::$data['religion'];
        $nationality = self::$data['nationality'];
        $personalData = new PersonalData($name, $nationalId, $pirthdate, $gender, $religion, $nationality);
        return $personalData;
    }

    private static function makePhoneObject(): Phone
    {
        $fixed  = self::$data['fixed_phone'];
        $mobile = self::$data['mobile'];
        $phone = new Phone($fixed, $mobile);
        return $phone;
    }

    private static function makeCityObject(): City
    {
        $id   = self::$data['city_id'];
        $name = self::$data['city_name'];
        $city = new City($id, $name);
        return $city;
    }

    private static function makeGovernorateObject(): Governorate
    {
        $id   = self::$data['governorate_id'];
        $name = self::$data['governorate_name'];
        $governorate = new Governorate($id, $name);
        return $governorate;
    }

    private static function makeSocialDataObject(): SocialData
    {
        $maritialStatus = self::$data['martial_status'];
        $childrenCount = self::$data['children_count'];
        $socialData = new SocialData($maritialStatus, $childrenCount);
        return $socialData;
    }

    private static function makeAddressObject(): Address
    {
        $city = self::makeCityObject();
        $governorate = self::makeGovernorateObject();
        $district = self::$data['district'];
        $street = self::$data['street'];
        $address = new Address($governorate, $city, $district, $street);
        return $address;
    }
}
