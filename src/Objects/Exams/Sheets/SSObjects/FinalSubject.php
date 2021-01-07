<?php

namespace SM\Objects\Exams\Sheets\SSObjects;

use SM\Objects\Exams\Sheets\SSObjects\Semester\Semester;

class FinalSubject extends AbstractFinalSubject
{
    public function getFirstSemester(): Semester
    {
        return $this->firstSemester;
    }

    public function getSecondSemester(): Semester
    {
        return $this->secondSemester;
    }

    public function toArray(): array
    {
        return [
            'fs' => [
                'evaluation' => [
                    'isAbsence' => $this->getFirstSemester()->getEvaluationDegree()->isAbsence(),
                    'value' => $this->getFirstSemester()->getEvaluationDegree()->getValue()
                ],
                'written' => [
                    'isAbsence' => $this->getFirstSemester()->getWrittenDegree()->isAbsence(),
                    'value' => $this->getFirstSemester()->getWrittenDegree()->getValue()
                ]
            ],
            'ss' => [
                'evaluation' => [
                    'isAbsence' => $this->getSecondSemester()->getEvaluationDegree()->isAbsence(),
                    'value' => $this->getSecondSemester()->getEvaluationDegree()->getValue()
                ],
                'written' => [
                    'isAbsence' => $this->getSecondSemester()->getWrittenDegree()->isAbsence(),
                    'value' => $this->getSecondSemester()->getWrittenDegree()->getValue()
                ]
            ],
            'subjectResult' => [
                'total' => [
                    'isAbsence' => $this->getTotal()->isAbsence(),
                    'value' => $this->getTotal()->getValue()
                ],
                'netDegree' => [
                    'isAbsence' => $this->getNetDegree()->isAbsence(),
                    'value' => $this->getNetDegree()->getValue()
                ],
                'grade' => [
                    'isAbsence' => $this->getGrade()->isAbsence(),
                    'value' => $this->getGrade()->grade()
                ]
            ]
        ];
    }
}
