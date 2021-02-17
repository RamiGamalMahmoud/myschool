<?php

namespace SM\Repos\EmployeesAffairs\JobData;

interface IPresenceStatusRepo
{
    public function getById($id);
    public function getAll();
    public function update($id, $attitude);
    public function create($id, $attitude);
    public function remove($id);
}
