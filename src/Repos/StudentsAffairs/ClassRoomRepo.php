<?php

namespace SM\Repos\StudentsAffairs;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Helpers\Log;
use SM\Entities\StudentsAffairs\ClassRoom;
use SM\Entities\StudentsAffairs\Grade;
use SM\Repos\BaseRepo;

class ClassRoomRepo extends BaseRepo implements IClassRoomRepo
{
    public function __construct(IDataAccess $dataAccess)
    {
        parent::__construct($dataAccess, 'class_room');
    }

    public function getAll(): ?array
    {
        $columns = [
            $this->table . '.id',
            $this->table . '.class_number',
            $this->table . '.class_name',
            'grade.id AS grade_id',
            'grade.grade_number',
            'grade.grade_name'
        ];

        $query = new Query();
        $query->select($columns)
            ->from($this->table)
            ->join('grade')
            ->on($this->table . '.grade_id', 'grade.id')
            ->orderBy(['grade.grade_number', $this->table . '.class_number']);

        $data = $this->dataAccess->getAll($query);
        $classRooms = array_map(function ($classRoom) {
            $grade = new Grade($classRoom['grade_id'], $classRoom['grade_number'], $classRoom['grade_name']);
            $cls = new ClassRoom($classRoom['id'], $classRoom['class_number'], $classRoom['class_name'], $grade);
            return $cls;
        }, $data);
        return $classRooms;
    }
}
