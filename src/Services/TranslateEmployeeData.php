<?php

namespace SM\Services;

use SM\Entities\EmployeesAffairs\AttitudeToWork;
use SM\Entities\EmployeesAffairs\MartialStatus;
use SM\Entities\EmployeesAffairs\PresenceStatus;
use SM\Helpers\Translate;

class TranslateEmployeeData
{
    public static function translateEmployee($employee)
    {
        $translateData = [];
        $translateData['id'] = $employee['id'];
        $translateData['personal-data'] = self::translatePersonalData($employee['personal-data']);
        $translateData['address'] = $employee['address'];
        $translateData['phone'] = self::translatePhone($employee['phone']);
        return $translateData;
    }

    public static function translatePhone(array $phone)
    {
        return [
            'fixed'  => Translate::convertNumbers($phone['fixed']),
            'mobile' => Translate::convertNumbers($phone['mobile'])
        ];
    }

    public static function translatePersonalData(array $personalData): array
    {
        $translateData  = [
            'name' => $personalData['name'],
            'national-id' => Translate::convertNumbers($personalData['national-id']),
            'pirthdate' => Translate::convertDate($personalData['pirthdate']),
            'gender' => [
                'key' => $personalData['gender'],
                'value' => Translate::get('gender', $personalData['gender'])
            ],
            'religion' => [
                'key' => $personalData['religion'],
                'value' => Translate::get('religion', $personalData['religion'])
            ],
            'nationality' => [
                'key' => $personalData['nationality'],
                'value' => Translate::get('nationality', $personalData['nationality'])
            ],
            'date-of-hiring' => Translate::convertDate($personalData['date-of-hiring']),
            'date-of-work-received' => Translate::convertDate($personalData['date-of-work-received']),
            'employee-type' => [
                'key' => $personalData['employee-type'],
                'value' => Translate::get('job-data.employee-type', $personalData['employee-type'])
            ]
        ];
        return $translateData;
    }

    public static function translateSocialStatus(array $socialStatus): array
    {
        $translateData = [
            'martial-status' => [
                'key' => $socialStatus['martial-status'],
                'value' => Translate::get('martial-status', $socialStatus['martial-status'])
            ],
            'children-count' => Translate::convertNumbers($socialStatus['children-count'])
        ];
        return $translateData;
    }

    public static function translateEmployeeStatus(array $employeeStatus): array
    {
        $translateData = [
            'presence-status' => [
                'key' => $employeeStatus['presence-status'],
                'value' => Translate::get('job-data.presence-status', $employeeStatus['presence-status'])
            ],
            'attitude-to-work' => [
                'key' => $employeeStatus['attitude-to-work'],
                'value' => Translate::get('job-data.attitude-to-work', $employeeStatus['attitude-to-work'])
            ]
        ];
        return $translateData;
    }

    public static function translateMartialStatus(MartialStatus $martialStatus): array
    {
        return [
            'id' => $martialStatus->getId(),
            'key' => $martialStatus->getMartialStatus(),
            'value' => Translate::get('martial-status', $martialStatus->getMartialStatus())
        ];
    }

    public static function translateAttitudeToWork(AttitudeToWork $attitudeToWork): array
    {
        return [
            'id' => $attitudeToWork->getId(),
            'key' => $attitudeToWork->getAttitude(),
            'value' => Translate::get('job-data.attitude-to-work', $attitudeToWork->getAttitude())
        ];
    }

    public static function translatePresenceStatus(PresenceStatus $presenceStatus)
    {
        return [
            'id' => $presenceStatus->getId(),
            'key' => $presenceStatus->getStatus(),
            'value' => Translate::get('job-data.presence-status', $presenceStatus->getStatus())
        ];
    }
}
