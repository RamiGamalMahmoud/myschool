<?php

namespace SM\Entities;

class WrittenEntity extends BaseEntity
{
    public $studentId = null;
    public $sittingNumber = null;
    public $studentName = null;
    public $classNumber = null;

    public $arabic = null;
    public $english = null;
    public $socialStudies = null;
    public $aljebra = null;
    public $geometry = null;
    public $sciences = null;
    public $religion = null;
    public $computer = null;
    public $draw = null;


    public static function getProps()
    {
        $arr = ['sittingNumber', 'studentName', 'classNumber'];
        $props = get_class_vars(__CLASS__);

        $result = [];
        foreach ($props as $key => $value) {
            if (!in_array($key, $arr)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
