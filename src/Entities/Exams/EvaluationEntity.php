<?php

namespace SM\Entities\Exams;

use SM\Objects\Exams\Degree;
use SM\Objects\Exams\Student;

class EvaluationEntity
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

        $this->arabic = new Degree(30, $data['arabic']);
        $this->english = new Degree(30, $data['english']);
        $this->socials = new Degree(30, $data['socialStudies']);
        $this->math = new Degree(30, $data['math']);
        $this->sciences = new Degree(30, $data['sciences']);
        $this->activity_1 = new Degree(100, $data['activity_1']);
        $this->activity_2 = new Degree(100, $data['activity_2']);
        $this->religion = new Degree(30, $data['religion']);
        $this->computer = new Degree(30, $data['computer']);
        $this->draw = new Degree(30, $data['draw']);
        $this->sports = new Degree(20, $data['sports']);

        $this->toArray();
    }

    public function toArray()
    {
        return [
            'studentData' => $this->student->toArray(),
            'arabic' => [
                'value' => $this->arabic->getValue(),
                'isAbsence' => $this->arabic->isAbsence()
            ],
            'english' => [
                'value' => $this->english->getValue(),
                'isAbsence' => $this->english->isAbsence()
            ],
            'socials' => [
                'value' => $this->socials->getValue(),
                'isAbsence' => $this->socials->isAbsence()
            ],
            'math' => [
                'value' => $this->math->getValue(),
                'isAbsence' => $this->math->isAbsence()
            ],
            'sciences' => [
                'value' => $this->sciences->getValue(),
                'isAbsence' => $this->sciences->isAbsence()
            ],
            'activity_1' => [
                'value' => $this->activity_1->getValue(),
                'isAbsence' => $this->activity_1->isAbsence()
            ],
            'activity_2' => [
                'value' => $this->activity_2->getValue(),
                'isAbsence' => $this->activity_2->isAbsence()
            ],
            'religion' => [
                'value' => $this->religion->getValue(),
                'isAbsence' => $this->religion->isAbsence()
            ],
            'computer' => [
                'value' => $this->computer->getValue(),
                'isAbsence' => $this->computer->isAbsence()
            ],
            'draw' => [
                'value' => $this->draw->getValue(),
                'isAbsence' => $this->draw->isAbsence()
            ],
            'sports' => [
                'value' => $this->sports->getValue(),
                'isAbsence' => $this->sports->isAbsence()
            ]
        ];
    }
}
