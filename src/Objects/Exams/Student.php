<?php

namespace SM\Objects\Exams;

use Exception;

class Student
{
    private ?string $_studentId;
    private ?string $_studentName;
    private ?string $_nationalId;
    private ?int    $_sittingNumber;
    private ?string $_enrollmentStatus;
    private ?int    $_classNumber;
    private ?string $_grade;

    public function __construct(array $data)
    {
        if (empty($data)) {
            throw new Exception('Student data should not be empty');
        }

        $this->_studentId        = $data['studentId'];
        $this->_studentName      = $data['studentName'];
        // $this->_nationalId = $data['nationalId'];
        $this->_sittingNumber    = $data['sittingNumber'];
        $this->_enrollmentStatus = $data['enrollmentStatus'];
        $this->_classNumber      = $data['classNumber'];
        $this->_grade            = $data['grade'];
    }

    public function getStudentId(): ?string
    {
        return $this->_studentId;
    }

    public function getStudentName(): ?string
    {
        return $this->_studentName;
    }

    public function getNationalId(): ?string
    {
        return $this->_nationalId;
    }

    public function getSittingNumber(): ?int
    {
        return $this->_sittingNumber;
    }

    public function getStudentEnrollmentStatus(): ?string
    {
        return $this->_enrollmentStatus;
    }

    public function getClassNumber(): ?int
    {
        return $this->_classNumber;
    }

    public function getGradeNumber(): ?int
    {
        return $this->_grade;
    }

    public function toArray(): array
    {
        $studentData = [];
        $studentData['studentId']        = $this->getStudentId();
        $studentData['studentName']      = $this->getStudentName();
        // $studentData['nationalId']       = $this->getNationalId();
        $studentData['sittingNumber']    = $this->getSittingNumber();
        $studentData['enrollmentStatus'] = $this->getStudentEnrollmentStatus();
        $studentData['classNumber']      = $this->getClassNumber();
        $studentData['gradeNumber']      = $this->getGradeNumber();
        return $studentData;
    }
}
