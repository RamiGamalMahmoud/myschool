<?php

namespace SM\Services\Facades;

use SM\Services\StudentsAffairs\ClassRoomService as StudentsAffairsClassRoomService;

class ClassroomService
{
    private static StudentsAffairsClassRoomService $classroomService;

    public static function init()
    {
        self::$classroomService = new StudentsAffairsClassRoomService();
    }

    public static function getAllClassrooms()
    {
    }

    public static function getClassroomById($id)
    {
        return self::$classroomService->getClassroomById($id);
    }
}

ClassroomService::init();
