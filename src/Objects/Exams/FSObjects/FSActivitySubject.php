<?php

namespace SM\Objects\Exams\FSObjects;

use Exception;
use SM\Objects\Exams\Grade;
use SM\Objects\Exams\Degree;

class FSActivitySubject
{
    protected string $subjectName;
    protected Degree $evaluation;

    protected float $min;
    protected float $subjectPercent;
    protected Degree $netDegree;
    protected Grade $grade;

    protected function calcGrade(): void
    {
        $this->grade = new Grade($this->evaluation);
    }

    protected function calcNetDegree(): void
    {
        if ($this->evaluation->isAssigned()) {
            if ($this->subjectPercent <= 100) {
                if ($this->evaluation->isAbsence()) {
                    $this->netDegree = new Degree($this->subjectPercent, -1);
                } else {
                    $this->netDegree = new Degree($this->subjectPercent, $this->evaluation->getValue() * $this->subjectPercent / 100);
                }
            } else {
                throw new Exception('Subject Degree value is grater than 100%');
            }
        } else {
            $this->netDegree = new Degree($this->subjectPercent, null);
        }
    }

    public function __construct(float $min, float $subjectPercent, string $subjectName)
    {
        $this->subjectName = $subjectName;
        $this->min = $min;
        $this->subjectPercent = $subjectPercent;
    }

    public function setDegrees(Degree $evaluation)
    {
        $this->evaluation = $evaluation;
        $this->calcNetDegree();
        $this->calcGrade();
    }

    /**
     * Get the final student grade
     * @return null|string
     */
    public function getGrade(): Grade
    {
        return $this->grade;
    }

    /**
     * Getting the student net degree
     * @return null|float
     * @throws \Exception
     */
    public function getNetDegree(): Degree
    {
        return $this->netDegree;
    }

    public function getEvaluationDegree(): Degree
    {
        return $this->evaluation;
    }

    public function getSubjectName(): string
    {
        return $this->subjectName;
    }

    public function toArray(): array
    {
        return [
            'evaluation' => [
                'value' => $this->getEvaluationDegree()->getValue(),
                'isAbsence' => $this->getEvaluationDegree()->isAbsence()
            ],
            'netDegree' => [
                'value' => $this->getNetDegree()->getValue(),
                'isAbsence' => $this->getNetDegree()->isAbsence()
            ],
            'grade' => [
                'grade' => $this->getGrade()->grade(),
                'isAbsence' => $this->getGrade()->isAbsence()
            ]
        ];
    }
}
