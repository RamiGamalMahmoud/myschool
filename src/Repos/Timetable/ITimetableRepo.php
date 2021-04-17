<?php

namespace SM\Repos\Timetable;

interface ITimetableRepo
{
    public function getAllDays(): array;
    public function getByDayId($dayId);
    public function isTeacherAvailable($teacherId, $subjectId, $periodId, $dayId);
    public function isClassroomAvailable($classroomId, $periodId, $dayId);
    public function getTimetableId($teacherId, $usbjectId, $dayId, $periodId);
    public function updateTimetable($id, $classroomId, $dayId, $periodId);
    public function createTimeTable($dayId,  $periodId, $classroomId, $teacherClassroomsId);
    public function deleteTimetable($id);
}
