<?php

namespace SM\Entities\Exams;

use SM\Entities\Entity;
use SM\Entities\TStudentPublicData;

class EvaluationEntity extends Entity
{
  use TStudentPublicData;

  public function getArabic()
  {
    return $this->get('arabic');
  }

  public function getEnglish()
  {
    return $this->get('english');
  }

  public function getSocialStudies()
  {
    return $this->get('socialStudies');
  }

  public function getMath()
  {
    return $this->get('math');
  }

  public function getSciences()
  {
    return $this->get('sciences');
  }

  public function getActivity_1()
  {
    return $this->get('activity_1');
  }

  public function getActivity_2()
  {
    return $this->get('activity_2');
  }

  public function getReligion()
  {
    return $this->get('religion');
  }

  public function getComputer()
  {
    return $this->get('computer');
  }

  public function getDraw()
  {
    return $this->get('draw');
  }

  public function getSports()
  {
    return $this->get('sports');
  }
}
