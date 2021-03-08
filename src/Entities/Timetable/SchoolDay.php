<?php

namespace SM\Entities\Timetable;

class SchoolDay
{
    private int $id;

    private string $dayName;

    private array $periods;

    public function __construct(int $id, string $dayName, array $periods)
    {
        $this->id = $id;
        $this->dayName = $dayName;
        $this->periods = $periods;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDayName()
    {
        return $this->dayName;
    }

    public function getPeriods()
    {
        return $this->periods;
    }

    public function getPeriod(int $number): ?Period
    {
        foreach ($this->periods as $period) {
            if ($period->getPeriodNumber() === $number) {
                return $period;
            }
        }
        return null;
    }

    public function getPeriodsCount()
    {
        return count($this->periods);
    }
}
