<?php

namespace SM\Entities;

trait TStudentSecrectData
{
    public function getStudentId()
    {
        return $this->get('studentId');
    }

    public function getFsSecrectNumber()
    {
        return $this->get('firstSemester');
    }

    public function getSsSecrectNumber()
    {
        return $this->get('secondSemester');
    }
}
