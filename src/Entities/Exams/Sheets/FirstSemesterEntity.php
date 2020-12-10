<?php

namespace SM\Entities\Exams\Sheets;

use SM\Entities\Entity;
use SM\Entities\TStudentPublicData;
use SM\Entities\TStudentSecrectData;

class FirstSemesterEntity extends Entity
{
  public function getStudentId()
  {
    return
      $this->get('studentId');
  }

  public function getSittingNumber()
  {
    return
      $this->get('sittingNumber');
  }

  public function getStudentName()
  {
    return
      $this->get('studentName');
  }

  public function getClassNumber()
  {
    return
      $this->get('classNumber');
  }

  public function getEnrollmentStatus()
  {
    return
      $this->get('enrollmentStatus');
  }

  public function getGrade()
  {
    return
      $this->get('grade');
  }

  public function getFse_arabic()
  {
    return
      $this->get('fse_arabic');
  }

  public function getFsw_arabic()
  {
    return
      $this->get('fsw_arabic');
  }

  public function getNet_total_arabic()
  {
    return
      $this->get('net_total_arabic');
  }

  public function getGrade_arabic()
  {
    return
      $this->get('grade_arabic');
  }

  public function getFse_english()
  {
    return
      $this->get('fse_english');
  }

  public function getFsw_english()
  {
    return
      $this->get('fsw_english');
  }

  public function getNet_total_english()
  {
    return
      $this->get('net_total_english');
  }

  public function getGrade_english()
  {
    return
      $this->get('grade_english');
  }

  public function getFse_social()
  {
    return
      $this->get('fse_social');
  }

  public function getFsw_social()
  {
    return
      $this->get('fsw_social');
  }

  public function getNet_total_socials()
  {
    return
      $this->get('net_total_socials');
  }

  public function getGrade_socials()
  {
    return
      $this->get('grade_socials');
  }

  public function getFse_math()
  {
    return
      $this->get('fse_math');
  }

  public function getFsw_aljebra()
  {
    return
      $this->get('fsw_aljebra');
  }

  public function getFsw_geometry()
  {
    return
      $this->get('fsw_geometry');
  }

  public function getNet_total_math()
  {
    return
      $this->get('net_total_math');
  }

  public function getGrade_math()
  {
    return
      $this->get('grade_math');
  }

  public function getFse_sciences()
  {
    return
      $this->get('fse_sciences');
  }

  public function getFsp_sciences()
  {
    return
      $this->get('fsp_sciences');
  }

  public function getFsw_sciences()
  {
    return
      $this->get('fsw_sciences');
  }

  public function getNet_total_sciences()
  {
    return
      $this->get('net_total_sciences');
  }

  public function getGrade_sciences()
  {
    return
      $this->get('grade_sciences');
  }

  public function getFormal_total()
  {
    return
      $this->get('formal_total');
  }

  public function getFormal_total_grade()
  {
    return
      $this->get('formal_total_grade');
  }

  public function getNet_total_activity_1()
  {
    return
      $this->get('net_total_activity_1');
  }

  public function getGrade_activity_1()
  {
    return
      $this->get('grade_activity_1');
  }

  public function getNet_total_activity_2()
  {
    return
      $this->get('net_total_activity_2');
  }

  public function getGrade_activity_2()
  {
    return
      $this->get('grade_activity_2');
  }

  public function getFse_religion()
  {
    return
      $this->get('fse_religion');
  }

  public function getFsw_religion()
  {
    return
      $this->get('fsw_religion');
  }

  public function getNet_total_religion()
  {
    return
      $this->get('net_total_religion');
  }

  public function getGrade_religion()
  {
    return
      $this->get('grade_religion');
  }

  public function getFse_computer()
  {
    return
      $this->get('fse_computer');
  }

  public function getFsp_computer()
  {
    return
      $this->get('fsp_computer');
  }

  public function getFsw_computer()
  {
    return
      $this->get('fsw_computer');
  }

  public function getNet_total_computer()
  {
    return
      $this->get('net_total_computer');
  }

  public function getGrade_computer()
  {
    return
      $this->get('grade_computer');
  }

  public function getFse_draw()
  {
    return
      $this->get('fse_draw');
  }

  public function getFsw_draw()
  {
    return
      $this->get('fsw_draw');
  }

  public function getNet_total_draw()
  {
    return
      $this->get('net_total_draw');
  }

  public function getGrade_draw()
  {
    return
      $this->get('grade_draw');
  }

  public function getNet_total_sports()
  {
    return
      $this->get('net_total_sports');
  }

  public function getGrade_sports()
  {
    return
      $this->get('grade_sports');
  }

  public function getFinalGrade()
  {
    return
      $this->get('finalGrade');
  }

  public function getSecondRoundSubjects()
  {
    return
      $this->get('secondRoundSubjects');
  }
}
