<?php

namespace SM\Objects\Exams;

use Simple\Helpers\Functions;
use SM\Helpers\DegsCalculator;

class Grade
{
    private ?string $_grade;
    private ?bool $_isAbsence;
    private bool $_isAssigned;

    public function __construct(Degree $degree)
    {
        $this->_isAssigned = $degree->isAssigned();
        if ($degree->isAssigned() === true) {
            $this->_isAbsence = $degree->isAbsence();
            if ($this->_isAbsence) {
                $this->_grade = 'ABS';
            } else {
                $this->_grade = DegsCalculator::getGrade($degree->getMaxValue(), $degree->getValue());
            }
        } else {
            $this->_grade = '';
            $this->_isAbsence = null;
        }
    }

    public function grade()
    {
        return $this->_grade;
    }

    public function isAbsence()
    {
        return $this->_isAbsence;
    }

    public function isAssigned()
    {
        return $this->_isAssigned;
    }
}
