<?php

namespace SM\Services\Timetable;

use Simple\Core\DataAccess\MySQLAccess;
use SM\Entities\Timetable\SchoolDay;
use SM\Repos\Timetable\IPeriodRepo;
use SM\Repos\Timetable\ISchoolDayRepo;
use SM\Repos\Timetable\ITimetableRepo;
use SM\Repos\Timetable\PeriodRepo;
use SM\Repos\Timetable\SchoolDayRepo;
use SM\Repos\Timetable\TimetableRepo;

class TimetableService
{
    private ITimetableRepo $timetableRepo;

    private ISchoolDayRepo $schoolDayRepo;

    private IPeriodRepo $periodRepo;

    public function __construct()
    {
        $dataAccess = new MySQLAccess();
        $this->timetableRepo = new TimetableRepo($dataAccess);
        $this->schoolDayRepo = new SchoolDayRepo($dataAccess);
        $this->periodRepo = new PeriodRepo($dataAccess);
    }

    public function getAllSchoolDays()
    {
        $days = $this->schoolDayRepo->getAllDays();
        $schoolDays = array_map(function ($workday) {
            $periodsCount = $workday['periods_count'];
            $periodsInDay = $this->periodRepo->getPeriods($periodsCount);
            $schoolDay = new SchoolDay($workday['id'], $workday['day'], $periodsInDay);
            return $schoolDay;
        }, $days);
        return $schoolDays;
    }
}
