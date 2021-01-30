<?php

namespace SM\Objects\Address;

class Governorate
{
    private $id;

    private string $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getGovernorateId()
    {
        return $this->id;
    }

    public function getGovernorateName()
    {
        return $this->name;
    }

    public function toArray()
    {
        return [
            'governorate-id' => $this->getGovernorateId(),
            'governorate-name' => $this->getGovernorateName()
        ];
    }
}
