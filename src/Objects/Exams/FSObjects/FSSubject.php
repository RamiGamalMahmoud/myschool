<?php

namespace SM\Objects\Exams\FSObjects;

use SM\Objects\Exams\Degree;

class FSSubject extends AbstractFSSubject
{

    /**
     * Setting the subject degrees
     * @param \SM\Objects\Degree $evaluation
     * @param \SM\Objects\Degree $written
     * @return void
     */
    public function setDegrees(Degree $evaluation, Degree $written)
    {
        $this->evaluation = $evaluation;
        $this->written = $written;
        $this->maxTotalValue = $evaluation->getMaxValue() + $written->getMaxValue();
        $this->calcTotal([$this->getEvaluationDegree(), $this->getWrittenDegree()]);
        $this->calcNetDegree();
    }

    public function toArray(): array
    {
        return [
            'evaluation' => [
                'value' => $this->getEvaluationDegree()->getValue(),
                'isAbsence' => $this->getEvaluationDegree()->isAbsence()
            ],
            'written' => [
                'value' => $this->getWrittenDegree()->getValue(),
                'isAbsence' => $this->getWrittenDegree()->isAbsence()
            ],
            'total' => [
                'value' => $this->total->getValue(),
                'isAbsence' => $this->total->isAbsence()
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
