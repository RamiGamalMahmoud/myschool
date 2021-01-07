<?php

namespace SM\Helpers;

class Translate
{
    private static array $local;

    public static function init(array $local)
    {
        self::$local = $local;
    }

    public static function getSubjectName(string $subjectName): string
    {
        $local = self::$local['subject-names'];
        if (in_array($subjectName, array_keys($local))) {
            return $local[$subjectName];
        }
        return $subjectName;
    }

    public static function getStudentGrade(string $gradeName): string
    {
        return self::$local['studentGrade'][$gradeName];
    }

    public static function getStudentState(string $state, string $semester): string
    {
        if ($state === 'PASSED') {
            return self::$local['examStatus'][$state];
        }

        return self::$local['examStatus'][$state][$semester];
    }
}
