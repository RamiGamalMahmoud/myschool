<?php

namespace SM\Views\Helpers;

class Semester
{
    public static function semesterName(string $semester)
    {
        $semesters = [
            'fs'  => 'الفصل الدراسي الأول',
            'ss' => 'الفصل الدراسي الثاني',
            'fll-year' => 'آخر العام'
        ];
        return $semesters[$semester];
    }
}
