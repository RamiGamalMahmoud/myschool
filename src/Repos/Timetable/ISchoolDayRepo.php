<?php

namespace SM\Repos\Timetable;

interface ISchoolDayRepo
{
    public function getAllDays();
    public function getByDayId($dayId);
}
