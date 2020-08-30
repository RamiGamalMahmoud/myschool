<?php

use Simple\Core\IRequest;

class TRequest implements IRequest
{
    private $segements = [];
    public function __construct($parh = '')
    {
        $this->segements = [
            'monitoring',
            'evaluation',
            'fs'
        ];
    }

    public function getSegment(int $index)
    {
        return $this->segements[$index];
    }

    public function getSegments()
    {
    }

    public function getRequestBody()
    {
    }

    public function getAjaxData()
    {
    }

    public function getPath()
    {
    }

    public function getRequestMethod()
    {
    }
}
