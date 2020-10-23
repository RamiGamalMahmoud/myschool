<?php

namespace SM\Entities;

trait TStudentPublicData
{
  public function getStudentId()
  {
    return $this->get('studentId');
  }

  public function getSittingNumber()
  {
    return $this->get('sittingNumber');
  }

  public function getStudentName()
  {
    return $this->get('studentName');
  }

  public function getClassNumber()
  {
    return $this->get('classNumber');
  }
}
