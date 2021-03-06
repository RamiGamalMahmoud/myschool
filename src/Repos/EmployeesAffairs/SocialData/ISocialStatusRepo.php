<?php

namespace SM\Repos\EmployeesAffairs\SocialData;

use SM\Entities\EmployeesAffairs\SocialStatus;

interface ISocialStatusRepo
{
    public function getByEmployeeId($id): array;
    public function createOrUpdate(SocialStatus $socialStatus);
    public function create(SocialStatus $socialStatus);
    public function update(SocialStatus $socialStatus);
    public function isRecordExists(SocialStatus $socialStatus);
}
