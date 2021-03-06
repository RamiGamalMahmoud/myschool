<?php

namespace SM\Services\StudentsAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\StudentsAffairs\ClassRoomRepo;
use SM\Repos\StudentsAffairs\IClassRoomRepo;

class ClassRoomService
{
    private IClassRoomRepo $classroomRepo;

    public function __construct()
    {
        $this->classroomRepo = new ClassRoomRepo(new MySQLAccess());
    }

    public function getClassRooms()
    {
        return $this->classroomRepo->getAll();
    }

    public function getClassroomById($id)
    {
        return $this->classroomRepo->getByid($id);
    }
}
