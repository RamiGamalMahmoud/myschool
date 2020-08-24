<?php

namespace SM\Entities;

abstract class BaseEntity
{
    public $studentId = null;
    public abstract function getProps();
}
