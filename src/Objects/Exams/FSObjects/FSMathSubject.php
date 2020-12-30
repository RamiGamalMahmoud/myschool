<?php

namespace SM\Objects\Exams\FSObjects;

use SM\Objects\Exams\Degree;
use SM\Helpers\DegsCalculator;

class FSMathSubject extends AbstractFSSubject
{
    private Degree $aljebra;
    private Degree $geometry;

    private function calcWrittenTotal(array $degs)
    {
        $maxWrittenValue = $this->getAljebraDegree()->getMaxValue() +
            $this->getGeometryDegree()->getMaxValue();

        $this->written = new Degree($maxWrittenValue, DegsCalculator::calcTotal($degs));
    }

    /**
     * Setting the subject degrees
     * @param \SM\Objects\Degree $evaluation
     * @param \SM\Objects\Degree $written
     * @return void
     */
    public function setDegrees(Degree $evaluation, Degree $aljebra, Degree $geometry)
    {
        $this->evaluation = $evaluation;
        $this->aljebra = $aljebra;
        $this->geometry = $geometry;
        $this->calcWrittenTotal([$this->getAljebraDegree(), $this->getGeometryDegree()]);
        $this->maxTotalValue = $this->getEvaluationDegree()->getMaxValue() +
            $this->getWrittenDegree()->getmaxValue();
        $this->calcTotal([$this->getEvaluationDegree(), $this->getWrittenDegree()]);
        $this->calcNetDegree();
    }

    public function getAljebraDegree(): Degree
    {
        return $this->aljebra;
    }

    public function getGeometryDegree(): Degree
    {
        return $this->geometry;
    }

    public function toArray(): array
    {
        return [
            'evaluation' => [
                'value' => $this->getEvaluationDegree()->getValue(),
                'isAbsence' => $this->getEvaluationDegree()->isAbsence()
            ],
            'aljebra' => [
                'value' => $this->getAljebraDegree()->getValue(),
                'isAbsence' => $this->getAljebraDegree()->isAbsence()
            ],
            'geometry' => [
                'value' => $this->getGeometryDegree()->getValue(),
                'isAbsence' => $this->getGeometryDegree()->isAbsence()
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
