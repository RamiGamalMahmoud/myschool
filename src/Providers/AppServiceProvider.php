<?php

namespace SM\Providers;

use Simple\Contracts\ServiceProviderInterface;
use SM\Contracts\Services\EmployeeServiceInterface;
use SM\Services\EmployeesAffairs\EmployeeService;

class AppServiceProvider implements ServiceProviderInterface
{
    public function register()
    {
        app()->bind(EmployeeServiceInterface::class, function () {
            return new EmployeeService();
        });
    }
}
