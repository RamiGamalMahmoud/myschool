<?php

namespace SM\Objects\Exams\FSObjects;

use Exception;
use SM\Objects\Exams\Grade;
use SM\Objects\Exams\Degree;
use SM\Helpers\DegsCalculator;

abstract class AbstractFSSubject
{
    protected Degree $evaluation;
    protected Degree $written;

    protected Degree $total;
    protected Degree $netDegree;
    protected Grade $grade;

    protected bool $_isAllDegsAssigned = false;

    protected float $min;
    protected float $maxTotalValue;
    protected float $subjectPercent;

    /**
     * Calculates the subject total
     * If is there is any degree that not assigned then the total will be null
     * @return void
     */
    protected function calcTotal(array $degs)
    {
        $maxTotalValue = 0;
        foreach ($degs as $deg) {
            $maxTotalValue += $deg->getMaxValue();
        }
        $this->total = new Degree($maxTotalValue, DegsCalculator::calcTotal($degs));
    }

    protected function calcNetDegree()
    {
        if ($this->getSubjectTotal()->isAssigned()) {
            if ($this->getSubjectTotal()->isAbsence()) {
                $this->netDegree = new Degree($this->subjectPercent, -1);
            } else {
                $netDegree = $this->total->getValue() * $this->subjectPercent / 100;
                $this->netDegree = new Degree($this->subjectPercent, $netDegree);
            }
        } else {
            $this->netDegree = new Degree($this->subjectPercent, null);
        }
    }

    public function __construct(float $min, float $subjectPercent)
    {
        if ($subjectPercent > 100) {
            throw new Exception('Subject Degree value is grater than 100%');
        }

        $this->min = $min;
        $this->subjectPercent = $subjectPercent;
    }

    public function getEvaluationDegree(): Degree
    {
        return $this->evaluation;
    }

    public function getWrittenDegree(): Degree
    {
        return $this->written;
    }

    /**
     * The subject formal total
     * @return null|\SM\Objects\Exams\Degree
     */
    public function getSubjectTotal()
    {
        return $this->total;
    }

    /**
     * Get the final student grade
     * @return SM\Objects\Exams\Grade
     */
    public function getGrade(): Grade
    {
        return new Grade($this->total);

        // if ($this->total === null) {
        //     return null;
        // }

        // if ($this->total < 0) {
        //     return 'ABS';
        // } else {
        //     return DegsCalculator::getGrade($this->subjectPercent, $this->getNetDegree()->getValue());
        // }
    }

    /**
     * Getting the student net degree
     * @return null|\SM\Objects\Exams\Degree
     */
    public function getNetDegree(): Degree
    {
        return $this->netDegree;

        $netDegree = $this->total === null ? null : $this->total->getValue() * $this->subjectPercent / 100;
        return new Degree($this->subjectPercent, $netDegree);
    }

    abstract public function toArray(): array;
}
