<?php

namespace SM\Repos\General;

use SM\Entities\General\Subject;

interface ISubjectRepo
{
    public function getAll();

    public function getById($id): ?Subject;
}
