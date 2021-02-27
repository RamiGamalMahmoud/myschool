<?php

namespace SM\Views\EmployeesAffairs;

use Simple\Core\View;
use Simple\Helpers\Log;
use SM\Services\Address\AddressService;
use SM\Services\EmployeesAffairs\JobDataService;
use SM\Services\EmployeesAffairs\SocialDataService;
use SM\Services\TranslateEmployeeData;

class EmployeesAffairsView
{
    /**
     * @var string $mainTemplate
     */
    private string $mainTemplate = 'employees-affairs/employees-table/employees-table.twig';

    /**
     * @var string $editTemplate
     */
    private string $editTemplate = 'employees-affairs/edit-employee/edit-employee.twig';

    /**
     * @var array $contextData
     */
    private array $contextData;

    /**
     * Constructor
     * 
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->contextData = $data;
    }

    /**
     * Rndering the main view
     */
    public function showEmployeesTable($employees = [])
    {
        $translatedData = array_map(function ($employee) {
            return [
                'employee' => TranslateEmployeeData::translateEmployee($employee['employee']),
                'employee-status' => TranslateEmployeeData::translateEmployeeStatus($employee['employee-status']),
                'social-status' => TranslateEmployeeData::translateSocialStatus($employee['social-status'])
            ];
        }, $employees);
        $this->addToContextData('employees', $translatedData);
        View::render($this->mainTemplate, $this->contextData);
    }

    /**
     * Shows edit employee form
     */
    public function showEditView($employee)
    {
        $govId = $employee['employee']['address']['governorate']['id'];

        $addressService = new AddressService();
        $socialDataService = new SocialDataService();
        $jobDataService = new JobDataService();

        $allMartialStatuses = $socialDataService->getAllMartialStatus();
        $allPresenceStatus = $jobDataService->getAllPresenceStatus();
        $allAttitudes = $jobDataService->getAllAttitudes();

        $allAttitudes = array_map(function ($attitude) {
            return TranslateEmployeeData::translateAttitudeToWork($attitude);
        }, $allAttitudes);

        $allMartialStatuses = array_map(function ($martial) {
            return TranslateEmployeeData::translateMartialStatus($martial);
        }, $allMartialStatuses);

        $allPresenceStatus = array_map(function ($presenceStatus) {
            return TranslateEmployeeData::translatePresenceStatus($presenceStatus);
        }, $allPresenceStatus);

        $employeeType = [
            'management' => 'إدارة مدرسية',
            'teacher' => 'مدرس',
            'specialist' => 'أخاصئي',
            'lab-secretary' => 'أمين معمل',
            'employee' => 'إداري',
            'worker' => 'عامل'
        ];

        $gender = [];
        $religion = [];

        $this->addToContextData('cities', $addressService->getCitiesByGovernorate($govId));
        $this->addToContextData('governorates', $addressService->getGovernorates());
        $this->addToContextData('martialStatuses', $allMartialStatuses);
        $this->addToContextData('attitudes', $allAttitudes);
        $this->addToContextData('presenceStatuses', $allPresenceStatus);
        $this->addToContextData('gender', ['male', 'female']);
        $this->addToContextData('religion', ['muslim', 'christian']);
        $this->addToContextData('employeeType', $employeeType);
        $this->addToContextData('employee', $employee);

        View::render($this->editTemplate, $this->contextData);
    }

    /**
     * Sets the context data
     * 
     * @param array $data
     */
    public function setContextData(array $data)
    {
        $this->contextData['data'] = $data;
    }

    /**
     * Add item to the context data
     * 
     * @param array $name The item name
     * @param $data The data
     */
    public function addToContextData(string $name, $data)
    {
        $this->contextData[$name] = $data;
    }
}
