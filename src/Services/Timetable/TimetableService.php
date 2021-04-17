<?php

namespace SM\Services\Timetable;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Core\Response;
use SM\Entities\Timetable\SchoolDay;
use SM\Repos\Timetable\IPeriodRepo;
use SM\Repos\Timetable\ISchoolDayRepo;
use SM\Repos\Timetable\ITeacherRepo;
use SM\Repos\Timetable\ITimetableRepo;
use SM\Repos\Timetable\PeriodRepo;
use SM\Repos\Timetable\SchoolDayRepo;
use SM\Repos\Timetable\TeacherRepo;
use SM\Repos\Timetable\TimetableRepo;

class TimetableService
{
    private ITimetableRepo $timetableRepo;

    private ISchoolDayRepo $schoolDayRepo;

    private IPeriodRepo $periodRepo;

    private ITeacherRepo $teacherRepo;

    /**
     * Crate a scoolday from a workday
     * @param array $workday
     * @return \SM\Entities\Timetable\SchoolDay
     */
    private function createSchoolDay($workday)
    {
        $periodsCount = $workday['periods_count'];
        $periodsInDay = $this->periodRepo->getPeriods($periodsCount);
        return new SchoolDay($workday['id'], $workday['day'], $periodsInDay);
    }

    private function checkAvailability($data)
    {
        $classroomIsAvailable = $this->timetableRepo->isClassroomAvailable($data['classroomId'], $data['periodId'], $data['dayId']);
        $teacherIsAvailable = $this->timetableRepo->isTeacherAvailable($data['teacherId'], $data['subjectId'], $data['periodId'], $data['dayId']);
        return [
            'is-class-available' => $classroomIsAvailable,
            'is-teacher-available' => $teacherIsAvailable
        ];
    }

    private function updateOrCreateTimetable($data)
    {
        $timetableId = $this->timetableRepo->getTimetableId(
            $data['teacherId'],
            $data['subjectId'],
            $data['dayId'],
            $data['periodId']
        );

        if ($timetableId) {
            $this->timetableRepo->updateTimetable($timetableId, $data['classroomId'], $data['dayId'], $data['periodId']);
            return;
        }

        $teacherClassroomsId = $this->teacherRepo->getTeacherClassroomsId(
            $data['teacherId'],
            $data['subjectId'],
        );

        $this->timetableRepo->createTimeTable($data['dayId'], $data['periodId'], $data['classroomId'], $teacherClassroomsId);
    }

    public function __construct()
    {
        $dataAccess = new MySQLAccess();
        $this->timetableRepo = new TimetableRepo($dataAccess);
        $this->schoolDayRepo = new SchoolDayRepo($dataAccess);
        $this->periodRepo = new PeriodRepo($dataAccess);
        $this->teacherRepo = new TeacherRepo($dataAccess);
    }

    /**
     * Get all timetable days
     */
    public function getAllTimetableDays()
    {
        return $this->timetableRepo->getAllDays();
    }

    /**
     * Get one timetable day by it`s id
     * @param $dayId
     */
    public function getDayTimetable($dayId)
    {
        return $this->timetableRepo->getByDayId($dayId);
    }

    /**
     * Get one schoolday
     * @param $dayId
     */
    public function getSchoolDay($dayId)
    {
        $day = $this->schoolDayRepo->getByDayId($dayId);
        return $this->createSchoolDay($day);
    }

    /**
     * Get all schooldays
     * @return array of \SM\Entities\Timetable\SchoolDay
     */
    public function getAllSchoolDays()
    {
        $days = $this->schoolDayRepo->getAllDays();
        $schoolDays = array_map(function ($workday) {
            return $this->createSchoolDay($workday);
        }, $days);
        return $schoolDays;
    }

    public function updateTimetable($data)
    {
        if ($data['classroomId'] != 0) {
            $available = $this->checkAvailability($data);
            if (!$available['is-class-available']) {
                Response::send('classroom is not available', 422);
            } else if (!$available['is-teacher-available']) {
                Response::send('teacher is not available', 422);
            } else {
                $this->updateOrCreateTimetable($data);
            }
        } else {
            $timetableId = $this->timetableRepo->getTimetableId(
                $data['teacherId'],
                $data['subjectId'],
                $data['dayId'],
                $data['periodId']
            );
            $this->timetableRepo->deleteTimetable($timetableId);
        }
    }
}
