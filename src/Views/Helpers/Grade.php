<?php

namespace SM\Views\Helpers;

class Grade
{
    public static function gradeName(int $gradeNumber)
    {
        $gradeNames = [
            1 => 'الصف الأول',
            2 => 'الصف الثاني',
            3 => 'الصف الثالث'
        ];
        return $gradeNames[$gradeNumber];
    }
}
