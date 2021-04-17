<?php

namespace SM\Repos\Timetable;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Repos\BaseRepo;

class TimetableRepo extends BaseRepo implements ITimetableRepo
{
    public function __construct(IDataAccess $dataAccess)
    {
        parent::__construct($dataAccess, 'timetable');
    }

    public function getTimetableId($teacherId, $usbjectId, $dayId, $periodId)
    {
        $query = new Query();
        $query->select(['id'])
            ->from('timetable_view')
            ->where('teacher_id', '=', $teacherId)
            ->andWhere('subject_id', '=', $usbjectId)
            ->andWhere('day_id', '=', $dayId)
            ->andWhere('period_id', '=', $periodId);
        $timetableId = $this->dataAccess->get($query);
        if ($timetableId) {
            return $timetableId['id'];
        }
        return false;
    }

    public function getAllDays(): array
    {
        $query = new Query();
        $query->selectAll()->from('timetable_view');
        return $this->groupByDay($this->dataAccess->getAll($query));
    }

    public function getByDayId($dayId)
    {
        $query = new Query();
        $query->selectAll()->from('timetable_view')->where('day_id', '=', $dayId);
        return $this->groupByTeachers($this->dataAccess->getAll($query));
    }

    public function groupByDay($data)
    {
        $timetableDays = array_reduce($data, function ($acc, $day) {
            $className = explode('-', $day['class_name']);
            $className = array_reverse($className);
            $className = implode('-', $className);
            $acc[$day['day_id']][$day['teacher_id']][$day['subject_id']][$day['period_id']] = $className;
            return $acc;
        }, []);
        return $timetableDays;
    }

    public function groupByTeachers($data)
    {
        $timetableDays = array_reduce($data, function ($acc, $day) {
            $className = explode('-', $day['class_name']);
            $className = array_reverse($className);
            $className = implode('-', $className);
            $acc[$day['teacher_id']][$day['subject_id']][$day['period_id']] = $className;
            return $acc;
        }, []);
        return $timetableDays;
    }

    public function updateTimetable($id, $classroomId, $dayId, $periodId)
    {
        $query = new Query();
        $query->update('timetable')
            ->set(['classroom_id' => $classroomId])
            ->where('id', '=', $id);
        return $this->dataAccess->run($query);
    }

    public function createTimeTable($dayId,  $periodId, $classroomId, $teacherClassroomsId)
    {
        $query = new Query();
        $query->insertInto('timetable')
            ->values(
                [
                    'id' => null,
                    'day_id' => $dayId,
                    'classroom_id' => $classroomId,
                    'period_id' => $periodId,
                    'teacher_classrooms_id' => $teacherClassroomsId
                ]
            );
        return $this->dataAccess->run($query);
    }

    public function deleteTimetable($id)
    {
        $query = new Query();
        $query->delete()
            ->from('timetable')
            ->where('id', '=', $id);
        return $this->dataAccess->run($query);
    }

    public function isTeacherAvailable($teacherId, $usbjectId, $periodId, $dayId)
    {
        $query = new Query();
        $query->selectCount('id')
            ->from('timetable_view')
            ->where('teacher_id', '=', $teacherId)
            ->andWhere('subject_id', '!=', $usbjectId)
            ->andWhere('period_id', '=', $periodId)
            ->andWhere('day_id', '=', $dayId);
        $result = $this->dataAccess->get($query);
        return $result['count'] == 0;
    }

    public function isClassroomAvailable($classroomId, $periodId, $dayId)
    {
        $query = new Query();
        $query->selectCount('id')
            ->from('timetable_view')
            ->where('classroom_id', '=', $classroomId)
            ->andWhere('period_id', '=', $periodId)
            ->andWhere('day_id', '=', $dayId);
        $result = $this->dataAccess->get($query);
        return $result['count'] == 0;
    }
}
