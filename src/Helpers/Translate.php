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
        if (in_array($subjectName, self::$local)) {
            return self::$local[$subjectName];
        }
        return $subjectName;
    }
}
