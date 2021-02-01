<?php

namespace SM\Controllers\EmployeesAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Core\Request;
use Simple\Core\Router;
use Simple\Helpers\Log;
use SM\Repos\EmployeesAffairs\EmployeeRepo;
use SM\Repos\EmployeesAffairs\EmployeeRepoInterface;
use SM\Views\EmployeesAffairs\EmployeesAffairsView;

class EmployeesAffairsController
{
    /**
     * @var \Simple\Core\Request
     */
    private Request $request;

    /**
     * @var \Simple\Core\Router
     */
    private Router $router;

    /**
     * @var \SM\Repos\EmployeesAffairs\EmployeeRepoInterface
     */
    private EmployeeRepoInterface $employeeRepo;

    /**
     * @var \SM\Views\EmployeesAffairs\EmployeesAffairsView
     */
    private EmployeesAffairsView $view;

    /**
     * Construstor
     * 
     * @param \Simple\Core\Request $request
     * @param \Simple\Core\Router $router
     */
    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;
        $this->employeeRepo = new EmployeeRepo(new MySQLAccess());
        $this->view = new EmployeesAffairsView();
    }

    /**
     * 
     */
    public function index()
    {
        $employees = $this->employeeRepo->getAll();
        $employees = array_map(function ($employee) {
            return $employee->toArray();
        }, $employees);
        $this->view->addToContextData('employees', $employees);
        $this->view->showMainView();
    }

    /**
     * Show edit form
     */
    public function edit()
    {
        $id = $this->router->get('id');
        $employee = $this->employeeRepo->getById($id);
        $this->view->addToContextData('employee', $employee->toArray());
        $this->view->showEditView();
    }

    /**
     * Update employee
     */
    public function update()
    {
        $data = $this->request->getRequestBody();
        Log::dump($data);
    }

    /**
     * Get employees by attributes
     */
    public function getBy()
    {
        $name = $this->router->get('criteria');
        $value = $this->router->get('value');
        $employees = $this->employeeRepo->filterBy($name, $value);
        $employees = array_map(function ($employee) {
            return $employee->toArray();
        }, $employees);
        $this->view->addToContextData('employees', $employees);
        $this->view->showMainView();
    }
}
