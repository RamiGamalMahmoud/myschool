<?php

namespace SM\Entities\Exams\Sheets;

use SM\Objects\Exams\FSObjects\FSActivitySubject;
use SM\Objects\Exams\FSObjects\FSMathSubject;
use SM\Objects\Exams\FSObjects\FSPracticalSubject;
use SM\Objects\Exams\FSObjects\FSSubject;
use SM\Objects\Exams\Student;

trait FirstSemesterSheetTrait
{
    public function getStudentData(): Student
    {
        return $this->_studentData;
    }
    public function getArabicSubject(): FSSubject
    {
        return $this->arabic;
    }

    public function getEnglishSubject(): FSSubject
    {
        return $this->english;
    }

    public function getSocialsSubject(): FSSubject
    {
        return $this->socials;
    }

    public function getMathSubject(): FSMathSubject
    {
        return $this->math;
    }

    public function getSciencesSubject(): FSPracticalSubject
    {
        return $this->sciences;
    }

    public function getActivity_1(): FSActivitySubject
    {
        return $this->activity_1;
    }

    public function getActivity_2(): FSActivitySubject
    {
        return $this->activity_2;
    }

    public function getReligionSubject(): FSSubject
    {
        return $this->religion;
    }

    public function getComputerSubject(): FSPracticalSubject
    {
        return $this->computer;
    }

    public function getDrawSubject(): FSSubject
    {
        return $this->draw;
    }

    public function getSports(): FSActivitySubject
    {
        return $this->sports;
    }
}
