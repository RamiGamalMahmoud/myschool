<?php

namespace SM\Entities\EmployeesAffairs;

class PresenceStatus
{
    private $id;

    private $status;

    public function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'status' => $this->getStatus()
        ];
    }
}
