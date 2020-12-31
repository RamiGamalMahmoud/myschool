<?php

namespace SM\Objects\Exams;

class StudentState
{
    private string $_studentState;
    private array $_weaknessSubjects;

    public function __construct($semester, array $subjects)
    {
        $this->_weaknessSubjects = array_filter($subjects, function ($subject) {
            if ($subject->getGrade()->grade() === 'F' || $subject->getGrade()->isAbsence()) {
                return $subject;
            }
        });

        if (count($this->_weaknessSubjects) > 0) {
            $this->_studentState = 'FAILED';
        } else {
            $this->_studentState = 'PASSED';
        }
    }

    public function getState()
    {
        return $this->_studentState;
    }

    public function getWeaknessSubjects()
    {
        return $this->_weaknessSubjects;
    }

    public function toArray()
    {
        return [
            'state' => $this->_studentState,
            'weaknessSubjects' => $this->_weaknessSubjects
        ];
    }
}
