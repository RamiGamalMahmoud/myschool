<?php

namespace SM\Entities\Exams;

use SM\Objects\Exams\Degree;
use SM\Objects\Exams\Student;

class WrittenEntity
{
    private Degree $arabic;
    private Degree $english;
    private Degree $socials;
    private Degree $aljebra;
    private Degree $geometry;
    private Degree $sciences;
    private Degree $religion;
    private Degree $computer;
    private Degree $draw;

    private Student $student;


    public function __construct(array $data)
    {
        $this->init($data);
    }

    public function init(array $data)
    {
        $this->student = new Student([
            'studentId' => $data['id'],
            'sittingNumber' => $data['sitting_number'],
            'studentName' => $data['name'],
            'classNumber' => $data['class_number'],
            'enrollmentStatus' => null,
            'grade' => null
        ]);

        $this->arabic = new Degree(70, $data['arabic']);
        $this->english = new Degree(70, $data['english']);
        $this->socials = new Degree(70, $data['social_studies']);
        $this->aljebra = new Degree(35, $data['aljebra']);
        $this->geometry = new Degree(35, $data['geometry']);
        $this->sciences = new Degree(56, $data['sciences']);
        $this->religion = new Degree(70, $data['religion']);
        $this->computer = new Degree(56, $data['computer']);
        $this->draw = new Degree(70, $data['draw']);

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
            'aljebra' => [
                'value' => $this->aljebra->getValue(),
                'isAbsence' => $this->aljebra->isAbsence()
            ],
            'geometry' => [
                'value' => $this->geometry->getValue(),
                'isAbsence' => $this->geometry->isAbsence()
            ],
            'sciences' => [
                'value' => $this->sciences->getValue(),
                'isAbsence' => $this->sciences->isAbsence()
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
            ]
        ];
    }
}
