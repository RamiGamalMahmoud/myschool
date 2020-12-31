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
                'value' => $this->getTotal()->getValue(),
                'isAbsence' => $this->getTotal()->isAbsence()
            ],
            'grade' => [
                'grade' => $this->getGrade()->grade(),
                'isAbsence' => $this->getGrade()->isAbsence()
            ]
        ];
    }
}
