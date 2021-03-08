<?php

namespace SM\Entities\Timetable;

class Period
{
    private int $id;

    private int $number;

    private $startTime;

    private $endTime;

    private int $duration;

    public function __construct(int $id, int $number, ?int $startTime, ?int $endTime)
    {
        $this->id = $id;
        $this->number = $number;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPeriodNumber()
    {
        return $this->number;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }
}
