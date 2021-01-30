<?php

namespace SM\Views\EmployeesAffairs;

use Simple\Core\View;

class EmployeesAffairsView
{
    /**
     * @var string $mainTemplate
     */
    private string $mainTemplate;

    /**
     * @var string $editTemplate
     */
    private string $editTemplate;

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
}
