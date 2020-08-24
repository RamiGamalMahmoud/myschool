<?php

namespace SM\Entities;

use Simple\Helpers\Functions;

class EvaluationEntity extends BaseEntity
{
    public $sittingNumber = null;
    public $studentName = null;
    public $classNumber = null;

    public $arabic = null;
    public $english = null;
    public $socialStudies = null;
    public $math = null;
    public $sciences = null;
    public $activity_1 = null;
    public $activity_2 = null;
    public $religion = null;
    public $computer = null;
    public $draw = null;
    public $sports = null;

    public function getProps()
    {
        $arr = ['sittingNumber', 'studentName', 'classNumber'];
        $props = get_object_vars($this);

        $result = [];
        foreach($props as $key => $value){
            if(!in_array($key, $arr)){
                $result[$key] = $value;
            }
        }

        return $result;
    }
}