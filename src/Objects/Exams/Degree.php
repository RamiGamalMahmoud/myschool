<?php

namespace SM\Objects\Exams;

use Exception;

/**
 * Represents an exam degree
 */
class Degree
{
    /**
     * @var ?float
     */
    private ?float $value;

    /**
     * @var float
     */
    private float $maxValue;

    /**
     * @var ?bool
     */
    private ?bool $absence;

    /**
     * @var bool
     */
    private bool $assigned;

    private function init(float $maxValue, ?float $degree)
    {
        $this->maxValue = $maxValue;

        if ($degree > $maxValue) {
            throw new Exception('DEGREE SHOULD BE LESS THAN OR EQUALS TO MAX VALUE');
        }

        if ($degree === null) {
            $this->assigned = false;
            $this->absence = false;
            $this->value = null;
        } elseif ($degree < 0) {
            $this->assigned = true;
            $this->absence = true;
            $this->value = null;
        } else {
            $this->absence = false;
            $this->assigned = true;
            $this->value = $degree;
        }
    }

    public function __construct(float $maxValue, ?float $degree = null)
    {
        $this->init($maxValue, $degree);
    }

    /**
     * The actual degree value
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getMaxValue()
    {
        return $this->maxValue;
    }

    /**
     * Return True if the student is absence
     */
    public function isAbsence()
    {
        return $this->absence;
    }

    /**
     * Is the degree is assigned
     */
    public function isAssigned()
    {
        return $this->assigned;
    }
}
