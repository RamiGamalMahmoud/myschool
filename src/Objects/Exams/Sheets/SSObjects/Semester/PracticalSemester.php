<?php

namespace SM\Objects\Exams\Sheets\SSObjects\Semester;

use SM\Objects\Exams\Degree;

class PracticalSemester extends AbstractSemester
{
    protected Degree $_writtenExam;
    protected Degree $_practicalExam;

    public function __construct(Degree $evaluation, Degree $practicalExam, Degree $writtenExam)
    {
        $this->_practicalExam = $practicalExam;
        $this->_writtenExam = $writtenExam;
        $written = self::calcWrittenDegree([$writtenExam, $practicalExam]);
        parent::__construct($evaluation, $written);
    }

    public function getWrittenExamDegree(): Degree
    {
        return $this->_writtenExam;
    }

    public function getPracticalExamDegree(): Degree
    {
        return $this->_practicalExam;
    }
}
