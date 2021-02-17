<?php

namespace SM\Entities\EmployeesAffairs;

class AttitudeToWork
{
    private $id;

    private $attitude;

    public function __construct($id, $attitude)
    {
        $this->id = $id;
        $this->attitude = $attitude;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAttitude()
    {
        return $this->attitude;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'attitude' => $this->getAttitude()
        ];
    }
}
