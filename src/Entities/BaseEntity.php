<?php

namespace SM\Entities;

abstract class BaseEntity
{
    public $studentId = null;
    public static abstract function getProps();
}
