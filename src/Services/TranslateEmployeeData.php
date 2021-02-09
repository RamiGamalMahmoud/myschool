<?php

namespace SM\Services;

use SM\Entities\EmployeesAffairs\AttitudeToWork;
use SM\Entities\EmployeesAffairs\MartialStatus;
use SM\Helpers\Translate;

class TranslateEmployeeData
{
    public static function translateEmployee($employee)
    {
        $translateData = [];
        $translateData['id'] = $employee['id'];
        $translateData['personal-data'] = self::translatePersonalData($employee['personal-data']);
        $translateData['social-data'] = self::translateSocialData($employee['social-data']);
        $translateData['job-data'] = self::translateJobData($employee['job-data']);
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
            ]
        ];
        return $translateData;
    }

    public static function translateSocialData(array $socialData): array
    {
        $translateData = [
            'martial-status' => [
                'key' => $socialData['martial-status'],
                'value' => Translate::get('martial-status', $socialData['martial-status'])
            ],
            'children-count' => Translate::convertNumbers($socialData['children-count'])
        ];
        return $translateData;
    }

    public static function translateJobData(array $jobData): array
    {
        $translateData = [
            'date-of-hiring' => Translate::convertDate($jobData['date-of-hiring']),
            'date-of-work-received' => Translate::convertDate($jobData['date-of-work-received']),
            'employee-type' => [
                'key' => $jobData['employee-type'],
                'value' => Translate::get('job-data.employee-type', $jobData['employee-type'])
            ],
            'employee-status' => [
                'key' => $jobData['employee-status'],
                'value' => Translate::get('job-data.employee-status', $jobData['employee-status'])
            ],
            'attitude-to-work' => [
                'key' => $jobData['attitude-to-work'],
                'value' => Translate::get('job-data.attitude-to-work', $jobData['attitude-to-work'])
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
}
