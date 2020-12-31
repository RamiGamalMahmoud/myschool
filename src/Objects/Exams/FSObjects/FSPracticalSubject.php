<?php

namespace SM\Objects\Exams\FSObjects;

use SM\Objects\Exams\Degree;
use SM\Helpers\DegsCalculator;

class FSPracticalSubject extends AbstractFSSubject
{
    private Degree $practical;
    private Degree $writtenExam;

    private function calcWrittenTotal(array $degs)
    {
        $maxWrittenValue = $this->getPracticalDegree()->getMaxValue() +
            $this->getWrittenExam()->getMaxValue();
        $this->written = new Degree($maxWrittenValue, DegsCalculator::calcTotal($degs));
    }

    /**
     * Setting the subject degrees
     * @param \SM\Objects\Degree $evaluation
     * @param \SM\Objects\Degree $practical
     * @param \SM\Objects\Degree $writtenExam
     * @return void
     */
    public function setDegrees(Degree $evaluation, Degree $practical, Degree $writtenExam)
    {
        $this->evaluation = $evaluation;
        $this->practical = $practical;
        $this->writtenExam = $writtenExam;
        $this->calcWrittenTotal([$this->getPracticalDegree(), $this->getWrittenExam()]);
        $this->maxTotalValue = $this->getEvaluationDegree()->getMaxValue() +
            $this->getWrittenDegree()->getmaxValue();
        $this->calcTotal([$this->getEvaluationDegree(), $this->getWrittenDegree()]);
        $this->calcNetDegree();
    }

    public function getPracticalDegree(): Degree
    {
        return $this->practical;
    }

    public function getWrittenExam(): Degree
    {
        return $this->writtenExam;
    }

    public function toArray(): array
    {
        return [
            'evaluation' => [
                'value' => $this->getEvaluationDegree()->getValue(),
                'isAbsence' => $this->getEvaluationDegree()->isAbsence()
            ],
            'practical' => [
                'value' => $this->getPracticalDegree()->getValue(),
                'isAbsence' => $this->getPracticalDegree()->isAbsence()
            ],
            'written-exam' => [
                'value' => $this->getWrittenExam()->getValue(),
                'isAbsence' => $this->getWrittenExam()->isAbsence()
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
