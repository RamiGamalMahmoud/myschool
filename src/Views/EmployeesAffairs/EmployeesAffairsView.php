<?php

namespace SM\Views\EmployeesAffairs;

use Simple\Core\View;
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
            return TranslateEmployeeData::translateEmployee($employee);
        }, $employees);
        $this->addToContextData('employees', $translatedData);
        View::render($this->mainTemplate, $this->contextData);
    }

    /**
     * Shows edit employee form
     */
    public function showEditView()
    {

        $attitudes = [
            'ON_TOP_OF_WORK' => 'على رأس العمل',
            'DIED' => 'متوفى',
            'PENSIONER' => 'معاش',
            'SIXK_LEAVE' => 'أجازة مرضية',
            'UNPAID_LEAVE' => 'أجازة بدون مرتب',
            'CHILDCARE_LEAVE' => 'رعاية طفل',
            'FIRED' => 'مفصول',
            'LOANED' => 'إعارة',
            'MATERNITY_LEAVE' => 'عامل',
            'RESIGNED' => 'مستقيل',
            'RECRUIT' => 'مجند',
            'OUT_OF_WORK' => 'منقطع عن العمل'
        ];
        $employeeStatus = [
            'ORIGINAL' => 'أصلي',
            'DEPUTED' => 'منتدب',
            'MOVED' => 'تم نقله'
        ];
        $employeeType = [
            "MANAGEMENT" => 'إدارة مدرسية',
            "TEACHER" => 'مدرس',
            "EMPLOYEE" => 'إداري',
            "WORKER" => 'عامل'
        ];
        $this->addToContextData('attitudes', $attitudes);
        $this->addToContextData('employeeStatus', $employeeStatus);
        $this->addToContextData('employeeType', $employeeType);
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
