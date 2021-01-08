<?php

namespace SM\Objects\Exams;

class Total
{
    private Degree $_total;
    private Grade $_grade;

    public function __construct(float $maxValue, ?float $degree)
    {
        $this->_total = new Degree($maxValue, $degree);
        $this->_grade = new Grade($this->_total);
    }

    public function getTotal()
    {
        return $this->_total;
    }

    public function getGrade()
    {
        return $this->_grade;
    }

    public function toArray()
    {
        return [
            'total' => [
                'isAbsence' => $this->getTotal()->isAbsence(),
                'value' => $this->getTotal()->getValue()
            ],
            'grade' => [
                'isAbsence' => $this->getGrade()->isAbsence(),
                'value' => $this->getGrade()->grade()
            ]
        ];
    }
}
