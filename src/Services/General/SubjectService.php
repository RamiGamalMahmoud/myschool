<?php

namespace SM\Services\General;

use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\General\ISubjectRepo;
use SM\Repos\General\SubjectRepo;

class SubjectService
{
    /**
     * @var \SM\Repos\General\ISubjectRepo
     */
    private ISubjectRepo $subjectRepo;

    public function __construct()
    {
        $this->subjectRepo = new SubjectRepo(new MySQLAccess());
    }

    public function getAll()
    {
        return $this->subjectRepo->getAll();
    }

    public function getSubjectById($id)
    {
        return $this->subjectRepo->getById($id);
    }
}
