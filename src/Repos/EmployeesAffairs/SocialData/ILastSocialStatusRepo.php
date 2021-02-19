<?php

namespace SM\Repos\EmployeesAffairs\SocialData;

use SM\Entities\EmployeesAffairs\SocialStatus;

interface ILastSocialStatusRepo
{
    public function update(SocialStatus $socialStatus);
    public function create(SocialStatus $socialStatus);
}
