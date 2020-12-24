<?php

namespace SM\Entities;

class Entity
{
    private array $data;
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function get($key)
    {
        if (in_array($key, array_keys($this->data))) {
            return $this->data[$key];
        }
        return 'N/A';
    }
}
