<?php

namespace SM\Objects\Address;

class City
{
    private $id;

    private string $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getCityId()
    {
        return $this->id;
    }

    public function getCityName()
    {
        return $this->name;
    }

    public function toArray()
    {
        return [
            'id' => $this->getCityId(),
            'name' => $this->getCityName()
        ];
    }
}
