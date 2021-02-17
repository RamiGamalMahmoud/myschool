<?php

namespace SM\Controllers\EmployeesAffairs;

use Simple\Core\Router;
use Simple\Core\Request;
use Simple\Core\Redirect;
use SM\Builders\PersonBuilder;
use Simple\Core\DataAccess\MySQLAccess;
use Simple\Helpers\Log;
use SM\Controllers\ErrorController;
use SM\Repos\EmployeesAffairs\EmployeeRepo;
use SM\Repos\EmployeesAffairs\IEmployeeRepo;
use SM\Entities\EmployeesAffairs\SocialStatus;
use SM\Entities\EmployeesAffairs\EmployeeStatus;
use SM\Services\EmployeesAffairs\EmployeeService;
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
     * @var \SM\Repos\EmployeesAffairs\IEmployeeRepo
     */
    private IEmployeeRepo $employeeRepo;

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
     * Default action
     */
    public function index()
    {
        $this->showAll();
    }

    /**
     * Show all employees table
     */
    public function showAll()
    {
        $employeeService = new EmployeeService();
        $employees = $employeeService->getAll();
        $employees = array_map(function ($employee) {
            return [
                'employee' => $employee['employee']->toArray(),
                'employee-status' => $employee['employee-status']->toArray(),
                'social-status' => $employee['social-status']->toArray()
            ];
        }, $employees);
        $this->view->showEmployeesTable($employees);
    }

    /**
     * Show edit form
     */
    public function edit()
    {
        $employeeService = new EmployeeService();
        $employeeId = $this->router->get('id');
        $employee = $employeeService->getById($employeeId);
        $employee['employee'] = $employee['employee']->toArray();
        $employee['employee-status'] = $employee['employee-status']->toArray();
        $employee['social-status'] = $employee['social-status']->toArray();
        $this->view->showEditView($employee);
    }

    /**
     * Update employee
     */
    public function update()
    {
        $data = $this->request->getRequestBody()['post'];
        $employeeId = $data['id'];
        $personalData = array_merge($data['personal-data'], $data['address'], $data['phone']);
        $personalData['id'] = $employeeId;
        $updateDate = date('Y-m-d h:i:s');
        $employee = PersonBuilder::makeEmployeeObject($personalData);

        $employeeStatus = new EmployeeStatus(
            null,
            $employeeId,
            $data['employee-status']['attitude-to-work'],
            '',
            $data['employee-status']['presence-status'],
            '',
            $updateDate
        );

        $socialStatus = new SocialStatus(
            null,
            $employeeId,
            '',
            $data['social-status']['martial-status'],
            $data['social-status']['children-count'],
            $updateDate
        );
        $employeeService = new EmployeeService();
        $employeeService->saveEmployee(
            $employee,
            $employeeStatus,
            boolVal($data['employee-status']['is-dirty']),
            $socialStatus,
            boolVal($data['social-status']['is-dirty'])
        );
        Redirect::to('/' . $this->request->getPath());
    }

    /**
     * Get employees by criteria
     */
    public function getBy()
    {
        $filterType = $this->router->get('filter_type');
        $criteriaName = $this->router->get('criteria');
        $criteriaValue = $this->router->get('value');
        $employeeService = new EmployeeService();
        $employees = $employeeService->filterBy($filterType, $criteriaName, $criteriaValue);
        if (empty($employees)) {
            Redirect::to('/employees-affairs');
        }
        $employees = array_map(function ($employee) {
            return [
                'employee' => $employee['employee']->toArray(),
                'employee-status' => $employee['employee-status']->toArray(),
                'social-status' => $employee['social-status']->toArray()
            ];
        }, $employees);
        $this->view->showEmployeesTable($employees);
    }
}
