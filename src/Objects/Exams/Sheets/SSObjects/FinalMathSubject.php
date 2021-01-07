<?php

namespace SM\Objects\Exams\Sheets\SSObjects;

use Simple\Helpers\Functions;
use SM\Objects\Exams\Sheets\SSObjects\Semester\MathSemester;

class FinalMathSubject extends AbstractFinalSubject
{
    public function __construct(string $subjectName, MathSemester $firstSemester, MathSemester $secondSemester, float $writtenSuccessDegree, float $subjectPercent)
    {
        parent::__construct($subjectName, $firstSemester, $secondSemester, $writtenSuccessDegree, $subjectPercent);
    }

    public function getFirstSemester(): MathSemester
    {
        return $this->firstSemester;
    }

    public function getSecondSemester(): MathSemester
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
                'aljebra' => [
                    'isAbsence' => $this->getFirstSemester()->getAljebraDegree()->isAbsence(),
                    'value' => $this->getFirstSemester()->getAljebraDegree()->getValue()
                ],
                'geometry' => [
                    'isAbsence' => $this->getFirstSemester()->getGeometryDegree()->isAbsence(),
                    'value' => $this->getFirstSemester()->getGeometryDegree()->getValue()
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
                'aljebra' => [
                    'isAbsence' => $this->getSecondSemester()->getAljebraDegree()->isAbsence(),
                    'value' => $this->getSecondSemester()->getAljebraDegree()->getValue()
                ],
                'geometry' => [
                    'isAbsence' => $this->getSecondSemester()->getGeometryDegree()->isAbsence(),
                    'value' => $this->getSecondSemester()->getGeometryDegree()->getValue()
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
