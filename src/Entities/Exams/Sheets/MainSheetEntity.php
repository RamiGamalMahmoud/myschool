<?php

namespace SM\Entities\Exams\Sheets;

use SM\Helpers\DegsCalculator;
use SM\Objects\Exams\StudentState;
use SM\Objects\Exams\Total;

class MainSheetEntity extends AbstractMainSheet
{

    protected static float $maxBaseTotal;
    protected static float $maxOverallTotal;

    protected static function calcMaxTotals()
    {
        self::$maxOverallTotal = 0.0;
        self::$maxOverallTotal += self::$DEGS_SETTINGS["activities"]["ss-percent"];
        self::$maxOverallTotal += self::$DEGS_SETTINGS["activities"]["ss-percent"];

        self::$maxBaseTotal = 0.0;
        self::$maxBaseTotal += self::$DEGS_SETTINGS["arabic"]["ss-percent"];
        self::$maxBaseTotal += self::$DEGS_SETTINGS["english"]["ss-percent"];
        self::$maxBaseTotal += self::$DEGS_SETTINGS["socials"]["ss-percent"];
        self::$maxBaseTotal += self::$DEGS_SETTINGS["math"]["ss-percent"];
        self::$maxBaseTotal += self::$DEGS_SETTINGS["sciences"]["ss-percent"];

        self::$maxOverallTotal = self::$maxBaseTotal + (2 * self::$DEGS_SETTINGS["activities"]["ss-percent"]);
    }

    private function calcStdentState()
    {
        $subjects = [
            $this->getArabicSubject(),
            $this->getEnglishSubject(),
            $this->getSocialsSubject(),
            $this->getMathSubject(),
            $this->getSciencesSubject(),
            $this->getActivity_1(),
            $this->getActivity_2(),
            $this->getReligionSubject(),
            $this->getComputerSubject(),
            $this->getDrawSubject(),
            $this->getSportsSubject()
        ];

        $this->studentState = new StudentState($subjects);
    }

    private function calcTotals()
    {
        $baseSubjects = [
            $this->getArabicSubject()->getNetDegree(),
            $this->getEnglishSubject()->getNetDegree(),
            $this->getSocialsSubject()->getNetDegree(),
            $this->getMathSubject()->getNetDegree(),
            $this->getSciencesSubject()->getNetDegree()
        ];

        $activites = [
            $this->getActivity_1()->getNetDegree(),
            $this->getActivity_2()->getNetDegree()
        ];

        $fullSubjects = array_merge($activites, $baseSubjects);

        $this->baseTotal = new Total(self::$maxBaseTotal, DegsCalculator::calcTotal($baseSubjects));
        $this->overallTotal = new Total(self::$maxOverallTotal, DegsCalculator::calcTotal($fullSubjects));
    }

    public static function setDegsSettings(array $degsSettings)
    {
        parent::setDegsSettings($degsSettings);
        self::calcMaxTotals();
    }

    public function __construct(array $data)
    {
        $this->init($data);
        $this->calcStdentState();
        $this->calcTotals();
    }

    public function getBaseTotal(): Total
    {
        return $this->baseTotal;
    }

    public function getOverallTotal(): Total
    {
        return $this->overallTotal;
    }

    public function toArray(): array
    {
        return [
            'studentData' => $this->getStudentData()->toArray(),
            'arabic' => $this->_arabic->toArray(),
            'english' => $this->_english->toArray(),
            'socials' => $this->_socials->toArray(),
            'math' => $this->_math->toArray(),
            'sciences' => $this->_sciences->toArray(),
            'baseTotal' => $this->getBaseTotal()->toArray(),
            'activity_1' => $this->_activity_1->toArray(),
            'activity_2' => $this->_activity_2->toArray(),
            'overallTotal' => $this->getOverallTotal()->toArray(),
            'religion' => $this->_religion->toArray(),
            'computer' => $this->_computer->toArray(),
            'draw' => $this->_draw->toArray(),
            'sports' => $this->_sports->toArray(),
            'studentState' => $this->studentState->toArray()
        ];
    }
}
