<?php

namespace SM\Repos\General;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Helpers\Log;
use SM\Entities\General\Subject;
use SM\Repos\BaseRepo;

class SubjectRepo extends BaseRepo implements ISubjectRepo
{
    public function __construct(IDataAccess $dataAccess)
    {
        parent::__construct($dataAccess, 'subject');
    }

    public function getAll(): array
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table);
        $data = $this->dataAccess->getAll($query);
        $subjects = array_map(function ($subject) {
            return $this->createSubject($subject);
        }, $data);
        return $subjects;
    }

    public function getById($id): ?Subject
    {
        $query = new Query();
        $query->selectAll()
            ->from($this->table)
            ->where('id', '=', $id);
        $subject = $this->dataAccess->get($query);
        if ($subject) {
            return $this->createSubject($subject);
        } else {
            return null;
        }
    }

    private function createSubject($subject)
    {
        return new Subject(
            $subject['id'],
            $subject['subject_name'],
            $subject['arabic_name'],
            $subject['quorum'],
            $subject['color']
        );
    }
}
