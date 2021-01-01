<?php

namespace SM\Objects\Exams;

class StudentState
{
    private ?string $_studentState;
    private ?array $_weaknessSubjects;
    private bool $_isFullAssigned;

    public function __construct($semester, array $subjects)
    {
        $assigned = array_filter($subjects, function ($subject) {
            if ($subject->getGrade()->isAssigned()) {
                return $subject;
            }
        });

        $this->_isFullAssigned = count($assigned) === count($subjects);

        if ($this->_isFullAssigned !== true) {
            $this->_studentState = null;
            $this->_weaknessSubjects = null;
            return;
        }

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
