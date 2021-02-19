<?php

namespace SM\Repos\EmployeesAffairs;

interface IEmployeeDataRepo
{
    public function getAll();
    public function getById($id);
    public function getAllPresent();
    public function gitBy($key, $value);
}
