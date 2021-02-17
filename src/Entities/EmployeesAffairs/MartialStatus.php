<?php

namespace SM\Entities\EmployeesAffairs;

class MartialStatus
{
    private $id;

    private $martialStatus;

    public function __construct($id, $martialStatus)
    {
        $this->id = $id;
        $this->martialStatus = $martialStatus;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getMartialStatus()
    {
        return $this->martialStatus;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'martial-status' => $this->getMartialStatus()
        ];
    }
}
