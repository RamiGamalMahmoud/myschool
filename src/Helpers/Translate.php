<?php

namespace SM\Helpers;

class Translator
{
    private static array $local;

    public static function init(array $local)
    {
        self::$local = $local;
    }

    public static function getSubjectName(string $subjectName): string
    {
        return self::$local[$subjectName];
    }
}
