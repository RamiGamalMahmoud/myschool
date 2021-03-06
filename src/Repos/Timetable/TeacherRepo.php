<?php

namespace SM\Repos\Timetable;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Repos\BaseRepo;

class TeacherRepo extends BaseRepo implements ITeacherRepo
{
    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->table = 'teacher';
    }

    public function getAllTeachers(): array
    {
        $query = new Query();
        $query->select([
            'id', 'name', 'specialization_id', 'quorum', 'presence_status',
            'classrooms'
        ])
            ->from('teacher_view');
        $data = $this->dataAccess->getAll($query);
        return $data;
    }

    public function updateClassrooms(int $teacherId, $subjectId, $classrooms)
    {
        $query = new Query();
        $query->update('teacher_classrooms')
            ->set(['classrooms' => $classrooms])
            ->where('teacher_id', '=', $teacherId)
            ->andWhere('subject_id', '=', $subjectId);
        $this->dataAccess->run($query);
    }

    public function getTeacherById($id)
    {
        $query = new Query();
        $query->select([
            'id', 'name', 'specialization_id', 'quorum', 'presence_status',
            'classrooms'
        ])
            ->from('teacher_view')
            ->where('id', '=', $id);
        $data = $this->dataAccess->get($query);
        return $data;
    }
}
