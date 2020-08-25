<?php

namespace SM\Entities;

class PracticalEntity extends BaseEntity
{
    public $studentId = null;
    public $sittingNumber = null;
    public $studentName = null;
    public $classNumber = null;

    public $sciences = null;
    public $computer = null;

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
