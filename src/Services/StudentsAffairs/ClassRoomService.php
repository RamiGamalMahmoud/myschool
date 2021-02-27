<?php

namespace SM\Services\StudentsAffairs;

use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\StudentsAffairs\ClassRoomRepo;
use SM\Repos\StudentsAffairs\IClassRoomRepo;

class ClassRoomService
{
    private IClassRoomRepo $classRoomRepo;

    public function __construct()
    {
        $this->classRoomRepo = new ClassRoomRepo(new MySQLAccess());
    }

    public function getClassRooms()
    {
        return $this->classRoomRepo->getAll();
    }
}
