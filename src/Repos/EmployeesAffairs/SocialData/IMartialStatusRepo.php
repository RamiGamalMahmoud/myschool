<?php

namespace SM\Repos\EmployeesAffairs\SocialData;

interface IMartialStatusRepo
{
    public function getById($id);
    public function getAll();
    public function create(string $martialStatus);
    public function update($id, $martialStatus);
    public function remove($id);
}
