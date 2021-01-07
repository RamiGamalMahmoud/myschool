<?php

namespace SM\Entities\Exams\Sheets;

use SM\Entities\Entity;
use SM\Helpers\DegsCalculator;
use SM\Objects\Exams\Degree;
use SM\Objects\Exams\FSObjects\FSActivitySubject;
use SM\Objects\Exams\FSObjects\FSMathSubject;
use SM\Objects\Exams\FSObjects\FSPracticalSubject;
use SM\Objects\Exams\FSObjects\FSSubject;
use SM\Objects\Exams\Student;
use SM\Objects\Exams\StudentState;
use SM\Objects\Exams\Total;

class FirstSemesterSheetEntity
{

    use FirstSemesterSheetTrait;

    private Student $_studentData;

    private FSSubject $arabic;
    private FSSubject $english;
    private FSSubject $socials;
    private FSMathSubject $math;
    private FSPracticalSubject $sciences;
    private FSActivitySubject $activity_1;
    private FSActivitySubject $activity_2;
    private FSSubject $religion;
    private FSPracticalSubject $computer;
    private FSSubject $draw;
    private FSActivitySubject $sports;

    private Total $overallTotal;
    private Total $baseTotal;
    private StudentState $studentState;

    private static ?array $DEGS_SETTINGS = null;
    private static float $maxOverallTotal;
    private static float $maxBaseTotal;

    private static function calcMaxTotals()
    {

        self::$maxOverallTotal = 0.0;
        self::$maxOverallTotal += self::$DEGS_SETTINGS["activities"]["fs-percent"];
        self::$maxOverallTotal += self::$DEGS_SETTINGS["activities"]["fs-percent"];

        self::$maxBaseTotal = 0.0;
        self::$maxBaseTotal += self::$DEGS_SETTINGS["arabic"]["fs-percent"];
        self::$maxBaseTotal += self::$DEGS_SETTINGS["english"]["fs-percent"];
        self::$maxBaseTotal += self::$DEGS_SETTINGS["socials"]["fs-percent"];
        self::$maxBaseTotal += self::$DEGS_SETTINGS["math"]["fs-percent"];
        self::$maxBaseTotal += self::$DEGS_SETTINGS["sciences"]["fs-percent"];

        self::$maxOverallTotal = self::$maxBaseTotal + 2 * self::$DEGS_SETTINGS["activities"]["fs-percent"];
    }

    public static function setDegsSettings(array $DEGS_SETTINGS)
    {
        if (self::$DEGS_SETTINGS === null) {
            self::$DEGS_SETTINGS = $DEGS_SETTINGS;
        }
        self::calcMaxTotals();
    }

    public function __construct(array $data)
    {
        $this->init($data);
    }

    public function init(array $data)
    {

        $this->_studentData = new Student($data);

        $this->arabic = new FSSubject(50, self::$DEGS_SETTINGS["arabic"]["fs-percent"], "arabic");
        $this->arabic->setDegrees(
            new Degree(self::$DEGS_SETTINGS["arabic"]["evaluation"], $data['fse_arabic']),
            new Degree(self::$DEGS_SETTINGS["arabic"]["written"], $data['fsw_arabic'])
        );

        $this->english = new FSSubject(50, self::$DEGS_SETTINGS["english"]["fs-percent"], "english");
        $this->english->setDegrees(
            new Degree(self::$DEGS_SETTINGS["english"]["evaluation"], $data['fse_english']),
            new Degree(self::$DEGS_SETTINGS["english"]["written"], $data['fsw_english'])
        );

        $this->socials = new FSSubject(50, self::$DEGS_SETTINGS["socials"]["fs-percent"], "socials");
        $this->socials->setDegrees(
            new Degree(self::$DEGS_SETTINGS["socials"]["evaluation"], $data['fse_social']),
            new Degree(self::$DEGS_SETTINGS["socials"]["written"], $data['fsw_social'])
        );

        $this->math = new FSMathSubject(50, self::$DEGS_SETTINGS["math"]["fs-percent"], "math");
        $this->math->setDegrees(
            new Degree(self::$DEGS_SETTINGS["math"]["evaluation"], $data['fse_math']),
            new Degree(self::$DEGS_SETTINGS["math"]["aljebra"], $data['fsw_aljebra']),
            new Degree(self::$DEGS_SETTINGS["math"]["geometry"], $data['fsw_geometry'])
        );

        $this->sciences = new FSPracticalSubject(50, self::$DEGS_SETTINGS["sciences"]["fs-percent"], "sciences");
        $this->sciences->setDegrees(
            new Degree(self::$DEGS_SETTINGS["sciences"]["evaluation"], $data['fse_sciences']),
            new Degree(self::$DEGS_SETTINGS["sciences"]["practical"], $data['fsp_sciences']),
            new Degree(self::$DEGS_SETTINGS["sciences"]["written-exam"], $data['fsw_sciences'])
        );

        $this->activity_1 = new FSActivitySubject(50, self::$DEGS_SETTINGS['activities']['fs-percent'], "activity_1");
        $this->activity_1->setDegrees(
            new Degree(self::$DEGS_SETTINGS["activities"]["evaluation"], $data['fse_activity_1'])
        );

        $this->activity_2 = new FSActivitySubject(50, self::$DEGS_SETTINGS["activities"]["fs-percent"], "activity_2");
        $this->activity_2->setDegrees(
            new Degree(self::$DEGS_SETTINGS["activities"]["evaluation"], $data['fse_activity_2'])
        );

        $this->religion = new FSSubject(50, self::$DEGS_SETTINGS["religion"]["fs-percent"], "religion");
        $this->religion->setDegrees(
            new Degree(self::$DEGS_SETTINGS["religion"]["evaluation"], $data['fse_religion']),
            new Degree(self::$DEGS_SETTINGS["religion"]["written"], $data['fsw_religion'])
        );

        $this->computer = new FSPracticalSubject(50, self::$DEGS_SETTINGS["computer"]["fs-percent"], "computer");
        $this->computer->setDegrees(
            new Degree(self::$DEGS_SETTINGS["computer"]["evaluation"], $data['fse_computer']),
            new Degree(self::$DEGS_SETTINGS["computer"]["practical"], $data['fsp_computer']),
            new Degree(self::$DEGS_SETTINGS["computer"]["written-exam"], $data['fsw_computer'])
        );

        $this->draw = new FSSubject(50, self::$DEGS_SETTINGS["draw"]["fs-percent"], "draw");
        $this->draw->setDegrees(
            new Degree(self::$DEGS_SETTINGS["draw"]["evaluation"], $data['fse_draw']),
            new Degree(self::$DEGS_SETTINGS["draw"]["written"], $data['fsw_draw'])
        );

        $this->sports = new FSActivitySubject(50, self::$DEGS_SETTINGS["sports"]["fs-percent"], "sports");
        $this->sports->setDegrees(
            new Degree(self::$DEGS_SETTINGS["sports"]["evaluation"], $data['fs_sports'])
        );
        $this->calcTotals();
        $this->calcStdentState();
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
            $this->getSports()
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

    public function getStudentState(): StudentState
    {
        return $this->studentState;
    }

    public function getOverallTotal(): Total
    {
        return $this->overallTotal;
    }

    public function getBaseTotal(): Total
    {
        return $this->baseTotal;
    }

    public function toArray(): array
    {
        $studentResult = [];
        $studentResult['studentData'] = $this->getStudentData()->toArray();
        $studentResult['arabic'] = $this->getArabicSubject()->toArray();
        $studentResult['english'] = $this->getEnglishSubject()->toArray();
        $studentResult['arabic'] = $this->getArabicSubject()->toArray();
        $studentResult['socials'] = $this->getSocialsSubject()->toArray();
        $studentResult['math'] = $this->getMathSubject()->toArray();
        $studentResult['sciences'] = $this->getSciencesSubject()->toArray();

        $studentResult['baseTotal'] = $this->getBaseTotal()->toArray();

        $studentResult['overallTotal'] = $this->getOverallTotal()->toArray();

        $studentResult['activity_1'] = $this->getActivity_1()->toArray();
        $studentResult['activity_2'] = $this->getActivity_2()->toArray();

        $studentResult['religion'] = $this->getReligionSubject()->toArray();
        $studentResult['computer'] = $this->getComputerSubject()->toArray();
        $studentResult['draw'] = $this->getDrawSubject()->toArray();
        $studentResult['sports'] = $this->getSports()->toArray();

        $studentResult['studentState'] = $this->getStudentState()->toArray();
        return $studentResult;
    }
}
