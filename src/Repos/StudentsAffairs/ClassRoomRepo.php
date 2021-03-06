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
            $this->table . '.color',
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
        $classRooms = array_map(function ($classroom) {
            return $this->createClassroom($classroom);
        }, $data);
        return $classRooms;
    }

    public function getByid($id): ?ClassRoom
    {
        $columns = [
            $this->table . '.id',
            $this->table . '.class_number',
            $this->table . '.class_name',
            $this->table . '.color',
            'grade.id AS grade_id',
            'grade.grade_number',
            'grade.grade_name'
        ];

        $query = new Query();
        $query->select($columns)
            ->from($this->table)
            ->join('grade')
            ->on($this->table . '.grade_id', 'grade.id')
            ->where($this->table . '.id', '=', $id)
            ->orderBy(['grade.grade_number', $this->table . '.class_number']);
        $data = $this->dataAccess->get($query);

        return $data ? $this->createClassroom($data) : null;
    }

    private function createClassroom(array $classroom): ClassRoom
    {
        $classname = explode('-', $classroom['class_name']);
        $classname = array_reverse($classname);
        $classname = implode('-', $classname);
        $grade = new Grade(
            $classroom['grade_id'],
            $classroom['grade_number'],
            $classroom['grade_name']
        );
        $cls = new ClassRoom(
            $classroom['id'],
            $classroom['class_number'],
            $classname,
            $classroom['color'],
            $grade
        );
        return $cls;
    }
}
