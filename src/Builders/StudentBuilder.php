<?php

namespace SM\Builders;

use SM\Entities\StudentsAffairs\ClassRoom;
use SM\Entities\StudentsAffairs\Grade;
use SM\Entities\StudentsAffairs\Student;

class StudentBuilder
{
    public static function buildStudent(array $data)
    {
        $grade = new Grade($data['grade_id'], $data['grade_number'], $data['grade_name']);
        $classroom = new ClassRoom($data['class_room_id'], $data['class_number'], $data['class_name'], $grade);
        $student = new Student(
            $data['id'],
            $data['name'],
            $data['enrollment_status'],
            $data['religion'],
            $data['gender'],
            $data['national_id'],
            $data['pirthdate'],
            $data['pirth_day'],
            $data['pirth_month'],
            $data['pirth_year'],
            $data['class_room_id']
        );
        return [
            'student' => $student,
            'class-room' => $classroom
        ];
    }
}
