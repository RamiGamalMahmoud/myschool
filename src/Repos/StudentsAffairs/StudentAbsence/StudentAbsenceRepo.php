<?php

namespace SM\Repos\StudentsAffairs\StudentAbsence;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Helpers\Log;
use SM\Repos\BaseRepo;

class StudentAbsenceRepo extends BaseRepo implements IStudentAbsenceRepo
{
    public function __construct(IDataAccess $dataAccess)
    {
        parent::__construct($dataAccess, '');
        $this->table = 'student_absence';
    }
    public function getAll(string $date): array
    {
        $query = new Query();
        $query->call('get_absence_dates_by_grade', ['2021-02', 2]);
        $data = $this->dataAccess->getAll($query);
        return $data;

        $columns = [
            'students_data.id',
            'students_data.name',
            'grade.grade_name',
            'class_room.class_number',
            $this->table . '.absence_date'
        ];
        $query = new Query();
        $query->select($columns)
            ->from($this->table)
            ->righttJoin('students_data')
            ->on($this->table . '.student_id', 'students_data.id')
            ->join('class_room')
            ->on('students_data.class_room_id', 'class_room.id')
            ->join('grade')
            ->on('class_room.grade_id', 'grade.id')
            ->where('grade.grade_number', '=', 1)
            ->andWhere('student_absence.absence_date', 'like', $date . '%');
        $data = $this->dataAccess->getAll($query);
        $absence = array_map(function ($student) {
            // Log::dump($student);
        }, $data);
        return $data;
    }

    public function getByGrade(string $yearMonth, int $gradeNumber): array
    {
        $query = new Query();
        $query->call('get_absence_dates_by_grade', [$yearMonth, $gradeNumber]);
        $data = $this->dataAccess->getAll($query);
        return array_map(function ($student) {
            if ($student['absence_date'] !== null) {
                $student['absence_date'] = explode(',', $student['absence_date']);
            }
            return $student;
        }, $data);
    }

    public function getByClass(string $yearMonth, int $gradeNumber, int $classNumber): array
    {
        $query = new Query();
        $query->call('get_absence_dates_by_class', [$yearMonth, $gradeNumber, $classNumber]);
        $data = $this->dataAccess->getAll($query);
        return array_map(function ($student) {
            $student['absence_date'] = explode(',', $student['absence_date']);
            return $student;
        }, $data);
    }

    public function registerAbsence($studentId, $date)
    {
        $query = new Query();
        $query->insertInto('student_absence')
            ->values(['student_id' => $studentId, 'absence_date' => $date]);
        return $this->dataAccess->run($query);
    }

    public function removeRegisteredAbsence($studentId, $date)
    {
        $query = new Query();
        $query->delete()
            ->from('student_absence')
            ->where('student_id', '=', $studentId)
            ->andWhere('absence_date', '=', $date);
        return $this->dataAccess->run($query);
    }

    public function isRegistered($studentId, $date)
    {
        $query = new Query();
        $query->selectAll()
            ->from('student_absence')
            ->where('student_id', '=', $studentId)
            ->andWhere('absence_date', '=', $date);
        return $this->dataAccess->get($query);
    }
}
