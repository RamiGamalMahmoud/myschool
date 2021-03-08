<?php

namespace SM\Repos\Timetable;

use SM\Entities\Timetable\Period;

interface IPeriodRepo
{
    public function getAllPeriods(): array;
    public function getPeriods(int $count);
    public function getPeriodById($id): Period;
}
