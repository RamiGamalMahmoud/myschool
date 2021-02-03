<?php

namespace SM\Helpers;

class Translate
{
    private static array $local;

    private static function keyExists()
    {
    }

    public static function init(array $local)
    {
        self::$local = $local;
    }

    public static function getSubjectName(?string $subjectName): string
    {
        $local = self::$local['subject-name'];
        if (in_array($subjectName, array_keys($local))) {
            return $local[$subjectName];
        }
        return $subjectName;
    }

    public static function getStudentGrade(?string $gradeName): string
    {
        if (empty($gradeName) || $gradeName === null) {
            return '';
        }
        $local = self::$local['studentGrade'];
        if (in_array($gradeName, array_keys($local))) {
            return self::$local['studentGrade'][$gradeName];
        }
    }

    public static function getStudentState(?string $state, string $semester): string
    {
        if ($state === null) return '';
        if ($state === 'PASSED') {
            return self::$local['examStatus'][$state];
        }

        return self::$local['examStatus'][$state][$semester];
    }

    public static function get(string $path, $value)
    {
        $keys = explode('.', $path);
        $arr = self::$local;

        foreach ($keys as $key) {
            if (key_exists($key, $arr)) {
                $arr = $arr[$key];
            } else {
                return $value;
            }
        }
        if (key_exists($value, $arr)) {
            return $arr[$value];
        }
        return $value;
    }

    public static function convertNumbers($number)
    {
        $western = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
        $eastern = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩', ','];
        return str_replace($western, $eastern, $number);
    }

    public static function convertDate($date)
    {
        $dateItems = array_reverse(explode('-', $date));
        $_date = implode('-', $dateItems);
        return self::convertNumbers($_date);
    }
}
