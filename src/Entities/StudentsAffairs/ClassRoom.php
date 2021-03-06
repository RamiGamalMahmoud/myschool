<?php

namespace SM\Entities\StudentsAffairs;

class ClassRoom
{
    private $id;

    private int $classNumber;

    private string $className;

    private string $color;

    private Grade $grade;

    public function __construct($id, $classNumber, $className, $color, Grade $grade)
    {
        $this->id = $id;
        $this->classNumber = $classNumber;
        $this->className = $className;
        $this->color = $color;
        $this->grade = $grade;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getClassNumber()
    {
        return $this->classNumber;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getClassColor()
    {
        return $this->color;
    }

    public function getGradeId()
    {
        return $this->grade->getId();
    }

    public function getGradeName()
    {
        return $this->grade->getGradeName();
    }

    public function getGradeNumber()
    {
        return $this->grade->getGradeNumber();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getGradeName(),
            'color' => $this->getClassColor(),
            'grade' => $this->grade->toArray()
        ];
    }
}
