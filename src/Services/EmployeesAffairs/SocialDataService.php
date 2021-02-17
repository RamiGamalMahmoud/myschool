<?php

namespace SM\Services\EmployeesAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Helpers\Log;
use SM\Entities\EmployeesAffairs\SocialStatus;
use SM\Repos\EmployeesAffairs\SocialData\IMartialStatusRepo;
use SM\Repos\EmployeesAffairs\SocialData\ISocialStatusRepo;
use SM\Repos\EmployeesAffairs\SocialData\MartialStatusRepo;
use SM\Repos\EmployeesAffairs\SocialData\SocialStatusRepo;

class SocialDataService
{
    private IMartialStatusRepo $martialStatusRepo;

    private ISocialStatusRepo $socialStatusRepo;

    public function __construct()
    {
        $dataAccess = new MySQLAccess();
        $this->martialStatusRepo = new MartialStatusRepo($dataAccess);
        $this->socialStatusRepo = new SocialStatusRepo($dataAccess);
    }

    public function getAllMartialStatus(): array
    {
        return $this->martialStatusRepo->getAll();
    }

    public function saveSocialStatus(SocialStatus $socialStatus)
    {
        if (!$this->socialStatusRepo->isRecordExists($socialStatus)) {
            $this->socialStatusRepo->create($socialStatus);
        }
    }
}
