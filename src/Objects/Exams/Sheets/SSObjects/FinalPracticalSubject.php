<?php

namespace SM\Objects\Exams\Sheets\SSObjects;

use SM\Objects\Exams\Sheets\SSObjects\Semester\PracticalSemester;

class FinalPracticalSubject extends AbstractFinalSubject
{
    public function __construct(string $subjectName, PracticalSemester $firstSemester, PracticalSemester $secondSemester, float $writtenSuccessDegree, float $subjectPercent)
    {
        parent::__construct($subjectName, $firstSemester, $secondSemester, $writtenSuccessDegree, $subjectPercent);
    }

    public function getFirstSemester(): PracticalSemester
    {
        return $this->firstSemester;
    }

    public function getSecondSemester(): PracticalSemester
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
                'practicalExam' => [
                    'isAbsence' => $this->getFirstSemester()->getPracticalExamDegree()->isAbsence(),
                    'value' => $this->getFirstSemester()->getPracticalExamDegree()->getValue()
                ],
                'writtenExam' => [
                    'isAbsence' => $this->getFirstSemester()->getWrittenExamDegree()->isAbsence(),
                    'value' => $this->getFirstSemester()->getWrittenExamDegree()->getValue()
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
                'practicalExam' => [
                    'isAbsence' => $this->getSecondSemester()->getPracticalExamDegree()->isAbsence(),
                    'value' => $this->getSecondSemester()->getPracticalExamDegree()->getValue()
                ],
                'writtenExam' => [
                    'isAbsence' => $this->getSecondSemester()->getWrittenExamDegree()->isAbsence(),
                    'value' => $this->getSecondSemester()->getWrittenExamDegree()->getValue()
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
