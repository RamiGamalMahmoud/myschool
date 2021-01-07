<?php

namespace SM\Objects\Exams\Sheets\SSObjects;

use SM\Helpers\DegsCalculator;
use SM\Objects\Exams\Degree;
use SM\Objects\Exams\Grade;
use SM\Objects\Exams\Sheets\SSObjects\Semester\ActivitySemester;

class FinalActivitySubject
{
    private string $activityName;
    private ActivitySemester $_firstSemester;
    private ActivitySemester $_secondSemester;
    private float $subjectPercent;

    private Degree $_total;
    private Degree $_netDegree;
    private Grade $_grade;

    private static function calcTotal(ActivitySemester $firstSemester, ActivitySemester $secondSemester)
    {
        $degs = [$firstSemester->getEvaluationDegree(), $secondSemester->getEvaluationDegree()];
        $maxTotal = array_reduce($degs, function ($carry, $deg) {
            return $carry + $deg->getMaxValue();
        }, 0);

        $total = DegsCalculator::calcTotal($degs);

        return new Degree($maxTotal, $total);
    }

    private static function calcNetDegree(Degree $total, float $subjectPercent)
    {
        if ($total->isAssigned()) {
            if ($total->isAbsence()) {
                return new Degree($subjectPercent, -1);
            } else {
                $avg = $total->getValue() / 2;
                $netDegree = $avg * $subjectPercent / 100;
                return new Degree($subjectPercent, $netDegree);
            }
        } else {
            return new Degree($subjectPercent, null);
        }
    }

    public function __construct(string $activityName, ActivitySemester $firstSemester, ActivitySemester $secondSemester, float $subjectPercent)
    {
        $this->activityName = $activityName;
        $this->_firstSemester = $firstSemester;
        $this->_secondSemester = $secondSemester;
        $this->subjectPercent = $subjectPercent;
        $this->_total = self::calcTotal($this->getFirstSemester(), $this->getSecondSemester());
        $this->_netDegree = self::calcNetDegree($this->getTotal(), $this->subjectPercent);
        $this->_grade = new Grade($this->getTotal());
    }

    public function getFirstSemester(): ActivitySemester
    {
        return $this->_firstSemester;
    }

    public function getSecondSemester(): ActivitySemester
    {
        return $this->_secondSemester;
    }

    public function getTotal(): Degree
    {
        return $this->_total;
    }

    public function getNetDegree(): Degree
    {
        return $this->_netDegree;
    }

    public function getGrade(): Grade
    {
        return $this->_grade;
    }

    public function getSubjectName(): string
    {
        return $this->activityName;
    }

    public function toArray()
    {
        return [
            'activityName' => $this->activityName,
            'fs' => [
                'isAbsence' => $this->getFirstSemester()->getEvaluationDegree()->isAbsence(),
                'value' => $this->getFirstSemester()->getEvaluationDegree()->getValue()
            ],
            'ss' => [
                'isAbsence' => $this->getSecondSemester()->getEvaluationDegree()->isAbsence(),
                'value' => $this->getSecondSemester()->getEvaluationDegree()->getValue()
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
