<?php

namespace SM\Controllers\EmployeesAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Core\Request;
use Simple\Core\Router;
use Simple\Helpers\Log;
use SM\Repos\EmployeesAffairs\EmployeeRepo;
use SM\Repos\EmployeesAffairs\EmployeeRepoInterface;

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
    }
}
