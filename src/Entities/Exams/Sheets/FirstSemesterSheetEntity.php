<?php

namespace SM\Entities\Exams\Sheets;

use Exception;
use Simple\Helpers\Functions;
use SM\Entities\Entity;
use SM\Helpers\DegsCalculator;
use SM\Objects\Exams\Degree;
use SM\Objects\Exams\FSObjects\FSActivitySubject;
use SM\Objects\Exams\FSObjects\FSMathSubject;
use SM\Objects\Exams\FSObjects\FSPracticalSubject;
use SM\Objects\Exams\FSObjects\FSSubject;
use SM\Objects\Exams\Grade;
use SM\Objects\Exams\Student;
use SM\Objects\Exams\StudentState;
use SM\Objects\Exams\Total;

class FirstSemesterSheetEntity extends Entity
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

    private static ?array $fs_degs_settings = null;
    private static float $maxOverallTotal;
    private static float $maxBaseTotal;

    private static function calcMaxTotals()
    {

        self::$maxOverallTotal = 0.0;
        self::$maxOverallTotal += self::$fs_degs_settings["activities"]["fs-percent"];
        self::$maxOverallTotal += self::$fs_degs_settings["activities"]["fs-percent"];

        self::$maxBaseTotal = 0.0;
        self::$maxBaseTotal += self::$fs_degs_settings["arabic"]["fs-percent"];
        self::$maxBaseTotal += self::$fs_degs_settings["english"]["fs-percent"];
        self::$maxBaseTotal += self::$fs_degs_settings["socials"]["fs-percent"];
        self::$maxBaseTotal += self::$fs_degs_settings["math"]["fs-percent"];
        self::$maxBaseTotal += self::$fs_degs_settings["sciences"]["fs-percent"];

        self::$maxOverallTotal = self::$maxBaseTotal + 2 * self::$fs_degs_settings["activities"]["fs-percent"];
    }

    public static function setDegsSettings(array $fs_degs_settings)
    {
        if (self::$fs_degs_settings === null) {
            self::$fs_degs_settings = $fs_degs_settings;
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

        $this->arabic = new FSSubject(50, self::$fs_degs_settings["arabic"]["fs-percent"], "arabic");
        $this->arabic->setDegrees(
            new Degree(self::$fs_degs_settings["arabic"]["evaluation"], $data['fse_arabic']),
            new Degree(self::$fs_degs_settings["arabic"]["written"], $data['fsw_arabic'])
        );

        $this->english = new FSSubject(50, self::$fs_degs_settings["english"]["fs-percent"], "english");
        $this->english->setDegrees(
            new Degree(self::$fs_degs_settings["english"]["evaluation"], $data['fse_english']),
            new Degree(self::$fs_degs_settings["english"]["written"], $data['fsw_english'])
        );

        $this->socials = new FSSubject(50, self::$fs_degs_settings["socials"]["fs-percent"], "socials");
        $this->socials->setDegrees(
            new Degree(self::$fs_degs_settings["socials"]["evaluation"], $data['fse_social']),
            new Degree(self::$fs_degs_settings["socials"]["written"], $data['fsw_social'])
        );

        $this->math = new FSMathSubject(50, self::$fs_degs_settings["math"]["fs-percent"], "math");
        $this->math->setDegrees(
            new Degree(self::$fs_degs_settings["math"]["evaluation"], $data['fse_math']),
            new Degree(self::$fs_degs_settings["math"]["aljebra"], $data['fsw_aljebra']),
            new Degree(self::$fs_degs_settings["math"]["geometry"], $data['fsw_geometry'])
        );

        $this->sciences = new FSPracticalSubject(50, self::$fs_degs_settings["sciences"]["fs-percent"], "sciences");
        $this->sciences->setDegrees(
            new Degree(self::$fs_degs_settings["sciences"]["evaluation"], $data['fse_sciences']),
            new Degree(self::$fs_degs_settings["sciences"]["practical"], $data['fsp_sciences']),
            new Degree(self::$fs_degs_settings["sciences"]["written-exam"], $data['fsw_sciences'])
        );

        $this->activity_1 = new FSActivitySubject(50, self::$fs_degs_settings['activities']['fs-percent'], "activity_1");
        $this->activity_1->setDegrees(
            new Degree(self::$fs_degs_settings["activities"]["evaluation"], $data['fse_activity_1'])
        );

        $this->activity_2 = new FSActivitySubject(50, self::$fs_degs_settings["activities"]["fs-percent"], "activity_2");
        $this->activity_2->setDegrees(
            new Degree(self::$fs_degs_settings["activities"]["evaluation"], $data['fse_activity_2'])
        );

        $this->religion = new FSSubject(50, self::$fs_degs_settings["religion"]["fs-percent"], "religion");
        $this->religion->setDegrees(
            new Degree(self::$fs_degs_settings["religion"]["evaluation"], $data['fse_religion']),
            new Degree(self::$fs_degs_settings["religion"]["written"], $data['fsw_religion'])
        );

        $this->computer = new FSPracticalSubject(50, self::$fs_degs_settings["computer"]["fs-percent"], "computer");
        $this->computer->setDegrees(
            new Degree(self::$fs_degs_settings["computer"]["evaluation"], $data['fse_computer']),
            new Degree(self::$fs_degs_settings["computer"]["practical"], $data['fsp_computer']),
            new Degree(self::$fs_degs_settings["computer"]["written-exam"], $data['fsw_computer'])
        );

        $this->draw = new FSSubject(50, self::$fs_degs_settings["draw"]["fs-percent"], "draw");
        $this->draw->setDegrees(
            new Degree(self::$fs_degs_settings["draw"]["evaluation"], $data['fse_draw']),
            new Degree(self::$fs_degs_settings["draw"]["written"], $data['fsw_draw'])
        );

        $this->sports = new FSActivitySubject(50, self::$fs_degs_settings["sports"]["fs-percent"], "sports");
        $this->sports->setDegrees(
            new Degree(self::$fs_degs_settings["sports"]["evaluation"], $data['fs_sports'])
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

        $this->studentState = new StudentState('', $subjects);
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
