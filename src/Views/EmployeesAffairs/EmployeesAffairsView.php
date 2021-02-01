<?php

namespace SM\Views\EmployeesAffairs;

use Simple\Core\View;
use SM\Entities\Employees\Employee;

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
    public function showMainView()
    {
        View::render($this->mainTemplate, $this->contextData);
    }

    /**
     * Shows edit employee form
     */
    public function showEditView()
    {
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
