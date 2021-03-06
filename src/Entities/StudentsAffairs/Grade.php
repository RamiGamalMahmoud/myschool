<?php

namespace SM\Entities\StudentsAffairs;

class Grade
{
    private $id;

    private int $gradeNumber;

    private string $gradeName;

    public function __construct($id, int $gradeNumber, string $gradeName)
    {
        $this->id = $id;
        $this->gradeNumber = $gradeNumber;
        $this->gradeName = $gradeName;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getGradeName()
    {
        return $this->gradeName;
    }

    public function getGradeNumber()
    {
        return $this->gradeNumber;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getGradeName(),
            'number' => $this->getGradeNumber()
        ];
    }
}
