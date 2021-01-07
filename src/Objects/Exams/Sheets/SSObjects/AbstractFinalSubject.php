<?php

namespace SM\Objects\Exams\Sheets\SSObjects;

use SM\Helpers\DegsCalculator;
use SM\Objects\Exams\Degree;
use SM\Objects\Exams\Grade;
use SM\Objects\Exams\Sheets\SSObjects\Semester\AbstractSemester;

abstract class AbstractFinalSubject
{
    protected string $subjectName;

    protected AbstractSemester $firstSemester;
    protected AbstractSemester $secondSemester;

    protected float $writtenSuccessDegree;

    protected float $subjectPercent;

    protected bool $_isAllDegsAssigned;
    protected Degree $_total;
    protected Degree $_netDegree;
    protected Grade $_grade;

    protected static function calcTotal(AbstractSemester $firstSemester, AbstractSemester $secondSemester)
    {
        $degs = [
            $firstSemester->getEvaluationDegree(),
            $firstSemester->getWrittenDegree(),
            $secondSemester->getEvaluationDegree(),
            $secondSemester->getWrittenDegree()
        ];

        $maxTotal = array_reduce($degs, function ($carry, $deg) {
            return $carry + $deg->getMaxValue();
        }, 0);
        $total = DegsCalculator::calcTotal($degs);
        return new Degree($maxTotal, $total);
    }

    protected static function calcNetDegree(Degree $total, float $subjectPercent)
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

    public function setWrittenSuccessDegree(float $writtenSuccessDegree)
    {
        $this->writtenSuccessDegree = $writtenSuccessDegree;
    }

    public function __construct(string $subjectName, AbstractSemester $firstSemester, AbstractSemester $secondSemester, float $writtenSuccessDegree, float $subjectPercent)
    {
        $this->subjectName = $subjectName;
        $this->firstSemester = $firstSemester;
        $this->secondSemester = $secondSemester;
        $this->writtenSuccessDegree = $writtenSuccessDegree;
        $this->subjectPercent = $subjectPercent;
        $this->_total = self::calcTotal($this->firstSemester, $this->secondSemester);
        $this->_netDegree = self::calcNetDegree($this->getTotal(), $this->subjectPercent);
        $this->_grade = new Grade($this->_total);
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
        return $this->subjectName;
    }

    abstract public function toArray(): array;
}
