<?php

namespace SM\Repos\StudentsAffairs;

use SM\Entities\StudentsAffairs\ClassRoom;

interface IClassRoomRepo
{
    public function getAll(): ?array;
    public function getByid($id): ?ClassRoom;
}
