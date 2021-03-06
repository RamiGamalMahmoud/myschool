<?php

namespace SM\Entities\Timetable;

use SM\Entities\General\Subject;

class Teacher
{
    private int $id;

    private string $name;

    private ?Subject $subject;

    private ?int $quorum;

    private ?array $classrooms;

    public function __construct(int $id, string $name, $classrooms, ?Subject $subject, ?int $quorum)
    {
        $this->id = $id;
        $this->name = $name;
        $this->subject = $subject;
        $this->quorum = $quorum;
        $this->classrooms = $classrooms;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getQuorum()
    {
        return $this->quorum;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getClassrooms()
    {
        return $this->classrooms;
    }

    public function toArray(): array
    {
        $classrooms = array_map(function ($_subject) {
            foreach ($_subject as $key => $value) {
                $result = [];
                $result['subject'] = $_subject['subject']->toArray();
                $result['classrooms'] = array_map(function ($_classroom) {
                    return $_classroom->toArray();
                }, $_subject['classrooms']);
            }
            return $result;
        }, $this->classrooms);

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'quorum' => $this->getQuorum(),
            'subject' => $this->getSubject()->toArray(),
            'classrooms' => $classrooms
        ];
    }
}
