<?php

namespace SM\Entities\Exams;

use SM\Objects\Exams\Degree;
use SM\Objects\Exams\Student;

class PracticalEntity
{
    private Degree $arabic;
    private Degree $english;
    private Degree $socials;
    private Degree $math;
    private Degree $sciences;
    private Degree $activity_1;
    private Degree $activity_2;
    private Degree $religion;
    private Degree $computer;
    private Degree $draw;
    private Degree $sports;

    private Student $student;


    public function __construct(array $data)
    {
        $this->init($data);
    }

    public function init(array $data)
    {
        $this->student = new Student([
            'studentId' => $data['studentId'],
            'sittingNumber' => $data['sittingNumber'],
            'studentName' => $data['studentName'],
            'classNumber' => $data['classNumber'],
            'enrollmentStatus' => null,
            'grade' => null
        ]);

        $this->sciences = new Degree(30, $data['sciences']);
        $this->computer = new Degree(30, $data['computer']);

        $this->toArray();
    }

    public function toArray()
    {
        return [
            'studentData' => $this->student->toArray(),
            'sciences' => [
                'value' => $this->sciences->getValue(),
                'isAbsence' => $this->sciences->isAbsence()
            ],
            'computer' => [
                'value' => $this->computer->getValue(),
                'isAbsence' => $this->computer->isAbsence()
            ]
        ];
    }
}
