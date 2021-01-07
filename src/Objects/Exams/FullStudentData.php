<?php

namespace SM\Objects\Exams;

use Exception;

class FullStudentData
{
    private string $_studentId;
    private string $_sittingNumber;
    private string $_studentName;
    private int $_classNumber;
    private int $_grade;
    private string $_sex;
    private string $_enrollmentStatus;
    private string $_religion;
    private string $_pirthDate;
    private int $_day;
    private int $_month;
    private int $_year;
    private string $_fs_secrets;
    private string $_ss_secrets;

    public function __construct(array $data)
    {
        $this->_studentId        = $data['studentId'];
        $this->_sittingNumber    = $data['sittingNumber'];
        $this->_studentName      = $data['studentName'];
        $this->_enrollmentStatus = $data['enrollmentStatus'];
        $this->_classNumber      = $data['classNumber'];
        $this->_grade            = $data['grade'];
        $this->_sex = $data['sex'];
        $this->_enrollmentStatus = $data['enrollmentStatus'];
        $this->_religion = $data['religion'];
        $this->_pirthDate = $data['pirthDate'];
        $this->_day = $data['day'];
        $this->_month = $data['month'];
        $this->_year = $data['year'];
        $this->_fs_secrets = $data['fs_secrets'];
        $this->_ss_secrets = $data['ss_secrets'];
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

    public function getStudentSex(): string
    {
        return $this->_sex;
    }

    public function getReligion(): string
    {
        return $this->_religion;
    }

    public function getPirthDate(): string
    {
        return $this->_pirthDate;
    }

    public function getPrithDay(): int
    {
        return $this->_day;
    }

    public function getPirthMonth(): int
    {
        return $this->_month;
    }

    public function getPrithYear(): int
    {
        return $this->_year;
    }

    public function getClassNumber(): ?int
    {
        return $this->_classNumber;
    }

    public function getGradeNumber(): ?int
    {
        return $this->_grade;
    }

    public function getFirstSemesterSecretNumber(): string
    {
        return $this->_fs_secrets;
    }

    public function getSecondSemesterSecretNumber(): string
    {
        return $this->_ss_secrets;
    }

    public function toArray(): array
    {
        return [
            'studentId'        => $this->getStudentId(),
            'sittingNumber'    => $this->getSittingNumber(),
            'studentName'      => $this->getStudentName(),
            'classNumber'      => $this->getClassNumber(),
            'gradeNumber'      => $this->getGradeNumber(),
            'sex' => $this->getStudentSex(),
            'enrollmentStatus' => $this->getStudentEnrollmentStatus(),
            'religion' => $this->getReligion(),
            'pirthDate' => $this->getPirthDate(),
            'pirthDay' => $this->getPrithDay(),
            'pirthMonth' => $this->getPirthMonth(),
            'pirthYear' => $this->getPrithYear(),
            'firstSemesterSecretNumber' => $this->getFirstSemesterSecretNumber(),
            'secondSemesterSecretNumber' => $this->getFirstSemesterSecretNumber()
        ];
    }
}
