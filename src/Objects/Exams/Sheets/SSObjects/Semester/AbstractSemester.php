<?php

namespace SM\Objects\Exams\Sheets\SSObjects\Semester;

use SM\Helpers\DegsCalculator;
use SM\Objects\Exams\Degree;

abstract class AbstractSemester
{
    protected Degree $_evaluation;
    protected Degree $_written;
    protected Degree $_total;
    protected bool $_isAssigned;

    protected static function calcWrittenDegree(array $degs): Degree
    {
        $maxWrittenValue = 0.0;
        $maxWrittenValue = array_reduce($degs, function ($carry, $item) {
            return $carry + $item->getMaxValue();
        }, 0);
        $written = DegsCalculator::calcTotal($degs);
        return new Degree($maxWrittenValue, $written);
    }

    protected static function calcTotal(array $degs): Degree
    {
        $maxTotal = 0.0;
        $maxTotal = array_reduce($degs, function ($carry, $deg) {
            return $carry + $deg->getMaxValue();
        }, 0);
        $total = 0.0;
        $total = DegsCalculator::calcTotal($degs);
        return new Degree($maxTotal, $total);
    }

    public function __construct(Degree $evaluation, Degree $written)
    {
        $this->_evaluation = $evaluation;
        $this->_written = $written;
        $this->_total = self::calcTotal([$this->_evaluation, $this->_written]);
    }

    public function getEvaluationDegree()
    {
        return $this->_evaluation;
    }

    public function getWrittenDegree()
    {
        return $this->_written;
    }

    public function getTotal()
    {
        return $this->_total;
    }

    public function isAssigned(): bool
    {
        return $this->getTotal()->isAssigned();
    }
}
