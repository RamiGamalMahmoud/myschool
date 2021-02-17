<?php

namespace SM\Builders;

use Simple\Helpers\Log;
use SM\Entities\Employees\Employee;
use SM\Entities\EmployeesAffairs\EmployeeStatus;
use SM\Entities\EmployeesAffairs\SocialStatus;
use SM\Objects\Phone;
use SM\Objects\Address\City;
use SM\Objects\PersonalData;
use SM\Objects\Address\Address;
use SM\Objects\Address\Governorate;

class PersonBuilder
{
    private static array $data;

    public static function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $newKey = str_replace('_', '-', $key);
            unset($data[$key]);
            $data[$newKey] = $value;
        }
        self::$data = $data;
    }

    public static function makeEmployeeObject(array $data): Employee
    {
        self::setData($data);
        $id = self::$data['id'];
        $personalData = self::makePersonalDataObject();
        $address = self::makeAddressObject();
        $phone = self::makePhoneObject();
        $employee = new Employee($id, $personalData, $address, $phone);
        return $employee;
    }

    private static function makePersonalDataObject(): PersonalData
    {
        $personalData = new PersonalData(
            self::$data['name'],
            self::$data['national-id'],
            self::$data['pirthdate'],
            self::$data['gender'],
            self::$data['religion'],
            self::$data['nationality'],
            self::$data['employee-type'],
            self::$data['date-of-hiring'],
            self::$data['date-of-work-received']
        );
        return $personalData;
    }

    private static function makePhoneObject(): Phone
    {
        $phone = new Phone(self::$data['fixed-phone'], self::$data['mobile']);
        return $phone;
    }

    private static function makeCityObject(): City
    {
        $city = new City(self::$data['city-id'], self::$data['city-name']);
        return $city;
    }

    private static function makeGovernorateObject(): Governorate
    {
        $governorate = new Governorate(
            self::$data['governorate-id'],
            self::$data['governorate-name']
        );
        return $governorate;
    }

    private static function makeAddressObject(): Address
    {
        $address = new Address(
            self::makeGovernorateObject(),
            self::makeCityObject(),
            self::$data['district'],
            self::$data['street']
        );
        return $address;
    }
}
