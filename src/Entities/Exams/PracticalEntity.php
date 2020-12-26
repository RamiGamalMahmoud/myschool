<?php

namespace SM\Entities\Exams;

use SM\Entities\Entity;
use SM\Entities\TStudentPublicData;

class PracticalEntity extends Entity
{
    use TStudentPublicData;

    public function getSciences()
    {
        return $this->get('sciences');
    }

    public function getComputer()
    {
        return $this->get('computer');
    }
}
