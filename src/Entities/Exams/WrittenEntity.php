<?php

namespace SM\Entities\Exams;

use SM\Entities\Entity;
use SM\Entities\TStudentPublicData;

class WrittenEntity extends Entity
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

  public function getAljebra()
  {
    return $this->get('aljebra');
  }

  public function getGeometry()
  {
    return $this->get('geometry');
  }

  public function getSciences()
  {
    return $this->get('sciences');
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
}
