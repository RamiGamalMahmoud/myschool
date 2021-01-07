<?php

namespace SM\Objects\Exams\Sheets\SSObjects\Semester;

use Simple\Helpers\Functions;
use SM\Objects\Exams\Degree;

class MathSemester extends AbstractSemester
{
    protected Degree $_aljebra;
    protected Degree $_geometry;

    public function __construct(Degree $evaluation, Degree $aljebra, Degree $geometry)
    {
        $this->_aljebra = $aljebra;
        $this->_geometry = $geometry;
        $writtenValue = self::calcWrittenDegree([$aljebra, $geometry]);
        parent::__construct($evaluation, $writtenValue);
    }

    public function getAljebraDegree()
    {
        return $this->_aljebra;
    }

    public function getGeometryDegree()
    {
        return $this->_geometry;
    }
}
