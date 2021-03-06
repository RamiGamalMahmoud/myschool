<?php

namespace SM\Services\Facades;

use SM\Services\General\SubjectService as GeneralSubjectService;

class SubjectService
{
    private static ?GeneralSubjectService $subjectService = null;

    public static function init()
    {
        if (self::$subjectService === null) {
            self::$subjectService = new GeneralSubjectService();
        }
    }

    public static function getAllSubjects()
    {
        return self::$subjectService->getAll();
    }

    public static function getSubjectById($id)
    {
        return self::$subjectService->getSubjectById($id);
    }
}

SubjectService::init();
