<?php

namespace SM\Entities\General;

class Subject
{
    private $id;

    private $subjectName;

    private $arabicName;

    private $color;

    private $quorum;

    public function __construct($id, $subjectName, $arabicName, $quorum, $color)
    {
        $this->id = $id;
        $this->subjectName = $subjectName;
        $this->arabicName = $arabicName;
        $this->quorum = $quorum;
        $this->color = $color;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSubjectName()
    {
        return $this->subjectName;
    }

    public function getArabicName()
    {
        return $this->arabicName;
    }

    public function getQuorum()
    {
        return $this->quorum;
    }

    public function getSubjectColor()
    {
        return $this->color;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getSubjectName(),
            'arabic-name' => $this->getArabicName(),
            'quorum' => $this->getQuorum(),
            'color' => $this->getSubjectColor()
        ];
    }
}
