<?php

namespace SM\Repos\StudentsAffairs;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Helpers\Log;
use SM\Builders\StudentBuilder;
use SM\Entities\StudentsAffairs\Student;
use SM\Repos\BaseRepo;

class StudentRepo extends BaseRepo implements IStudentRepo
{
    private array $columns;

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->table = 'students_data';

        $this->columns = [
            $this->table . '.id',
            $this->table . '.name',
            $this->table . '.enrollment_status',
            $this->table . '.religion',
            $this->table . '.gender',
            $this->table . '.national_id',
            $this->table . '.pirthdate',
            $this->table . '.pirth_day',
            $this->table . '.pirth_month',
            $this->table . '.pirth_year',
            $this->table . '.class_room_id',
            'grade.id AS grade_id',
            'grade.grade_number',
            'grade.grade_name',
            'class_room.class_number',
            'class_room.class_name'
        ];
    }
    public function getAll(): array
    {
        $query = $this->makeQuery();
        $query->orderBy(['grade.grade_number', 'class_room.class_number', $this->table . '.name']);
        $data = $this->dataAccess->getAll($query);
        $students = array_map(function ($student) {
            return StudentBuilder::buildStudent($student);
        }, $data);
        return $students;
    }

    public function getByGradeNumber(int $gradeNumber): array
    {
        $query = $this->makeQuery();
        $query->where('grade.grade_number', '=', $gradeNumber)
            ->orderBy(['grade.grade_number', 'class_room.class_number', $this->table . '.name']);
        $data = $this->dataAccess->getAll($query);
        $students = array_map(function ($student) {
            return StudentBuilder::buildStudent($student);
        }, $data);
        return $students;
    }

    public function getByClassNumber(int $gradeNumber, int $classNumber): array
    {
        $query = $this->makeQuery();
        $query->where('grade.grade_number', '=', $gradeNumber)
            ->andWhere('class_room.class_number', '=', $classNumber)
            ->orderBy(['grade.grade_number', 'class_room.class_number', $this->table . '.name']);

        $data = $this->dataAccess->getAll($query);
        $students = array_map(function ($student) {
            return StudentBuilder::buildStudent($student);
        }, $data);
        return $students;
    }

    public function getById(): Student
    {
        return new Student('', '', '', '', '', '', '', '', '', '', '');
    }

    private function makeQuery(): Query
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->join('class_room')
            ->on($this->table . '.class_room_id', 'class_room.id')
            ->join('grade')
            ->on('class_room.grade_id', 'grade.id');
        return $query;
    }
}
