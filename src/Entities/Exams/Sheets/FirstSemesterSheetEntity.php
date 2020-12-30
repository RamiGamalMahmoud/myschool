<?php

namespace SM\Entities\Exams\Sheets;

use Exception;
use SM\Entities\Entity;
use SM\Objects\Exams\Degree;
use SM\Objects\Exams\FSObjects\FSActivitySubject;
use SM\Objects\Exams\FSObjects\FSMathSubject;
use SM\Objects\Exams\FSObjects\FSPracticalSubject;
use SM\Objects\Exams\FSObjects\FSSubject;
use SM\Objects\Exams\Student;

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

    private Degree $formalTotal;
    private Degree $baseTotal;
    private string $studentGrade;
    private array $weaknessSubjects;

    private static ?array $fs_degs_settings = null;

    private function calcTotal()
    {
        $totals = [
            $this->arabic->getNetDegree(),
            $this->english->getNetDegree(),
            $this->socials->getNetDegree(),
            $this->math->getNetDegree(),
            $this->sciences->getNetDegree(),
            $this->activity_1->getNetDegree(),
            $this->activity_2->getNetDegree()
        ];

        $this->baseTotal = 0;
        $this->formalTotal = 0;

        $this->formalTotal = array_reduce($totals, function ($carry, $item) {
            if (!$item->isAbsence()) {
                return $item->getValue() + $carry;
            }
        }, 0);

        // $this->baseTotal += $this->arabic->getNetDegree();
        // $this->baseTotal += $this->english->getNetDegree();
        // $this->baseTotal += $this->socials->getNetDegree();
        // $this->baseTotal += $this->math->getNetDegree();
        // $this->baseTotal += $this->sciences->getNetDegree();

        // $this->formalTotal += $this->baseTotal;
        // $this->formalTotal += $this->activity_1->getNetDegree();
        // $this->formalTotal += $this->activity_2->getNetDegree();
    }
    public function __construct(array $fs_degs_settings, array $data)
    {
        if (empty($fs_degs_settings) || empty($data)) {
            throw new Exception('Degress settings or Degrees data should not be empty');
        }

        $this->init($fs_degs_settings, $data);
    }

    public function init(array $fs_degs_settings, array $data)
    {

        if (self::$fs_degs_settings === null) {
            self::$fs_degs_settings = $fs_degs_settings;
        }

        $this->_studentData = new Student($data);

        $this->arabic = new FSSubject(50, self::$fs_degs_settings["arabic"]["fs-percent"]);
        $this->arabic->setDegrees(
            new Degree(self::$fs_degs_settings["arabic"]["evaluation"], $data['fse_arabic']),
            new Degree(self::$fs_degs_settings["arabic"]["written"], $data['fsw_arabic'])
        );

        $this->english = new FSSubject(50, self::$fs_degs_settings["english"]["fs-percent"]);
        $this->english->setDegrees(
            new Degree(self::$fs_degs_settings["english"]["evaluation"], $data['fse_english']),
            new Degree(self::$fs_degs_settings["english"]["written"], $data['fsw_english'])
        );

        $this->socials = new FSSubject(50, self::$fs_degs_settings["socials"]["fs-percent"]);
        $this->socials->setDegrees(
            new Degree(self::$fs_degs_settings["socials"]["evaluation"], $data['fse_social']),
            new Degree(self::$fs_degs_settings["socials"]["written"], $data['fsw_social'])
        );

        $this->math = new FSMathSubject(50, self::$fs_degs_settings["math"]["fs-percent"]);
        $this->math->setDegrees(
            new Degree(self::$fs_degs_settings["math"]["evaluation"], $data['fse_math']),
            new Degree(self::$fs_degs_settings["math"]["aljebra"], $data['fsw_aljebra']),
            new Degree(self::$fs_degs_settings["math"]["geometry"], $data['fsw_geometry'])
        );

        $this->sciences = new FSPracticalSubject(50, self::$fs_degs_settings["sciences"]["fs-percent"]);
        $this->sciences->setDegrees(
            new Degree(self::$fs_degs_settings["sciences"]["evaluation"], $data['fse_sciences']),
            new Degree(self::$fs_degs_settings["sciences"]["practical"], $data['fsp_sciences']),
            new Degree(self::$fs_degs_settings["sciences"]["written-exam"], $data['fsw_sciences'])
        );

        $this->activity_1 = new FSActivitySubject(50, self::$fs_degs_settings['activities']['fs-percent']);
        $this->activity_1->setDegrees(
            new Degree(self::$fs_degs_settings["activities"]["evaluation"], $data['fse_activity_1'])
        );

        $this->activity_2 = new FSActivitySubject(50, self::$fs_degs_settings["activities"]["fs-percent"]);
        $this->activity_2->setDegrees(
            new Degree(self::$fs_degs_settings["activities"]["evaluation"], $data['fse_activity_2'])
        );

        $this->religion = new FSSubject(50, self::$fs_degs_settings["religion"]["fs-percent"]);
        $this->religion->setDegrees(
            new Degree(self::$fs_degs_settings["religion"]["evaluation"], $data['fse_religion']),
            new Degree(self::$fs_degs_settings["religion"]["written"], $data['fsw_religion'])
        );

        $this->computer = new FSPracticalSubject(50, self::$fs_degs_settings["computer"]["fs-percent"]);
        $this->computer->setDegrees(
            new Degree(self::$fs_degs_settings["computer"]["evaluation"], $data['fse_computer']),
            new Degree(self::$fs_degs_settings["computer"]["practical"], $data['fsp_computer']),
            new Degree(self::$fs_degs_settings["computer"]["written-exam"], $data['fsw_computer'])
        );

        $this->draw = new FSSubject(50, self::$fs_degs_settings["draw"]["fs-percent"]);
        $this->draw->setDegrees(
            new Degree(self::$fs_degs_settings["draw"]["evaluation"], $data['fse_draw']),
            new Degree(self::$fs_degs_settings["draw"]["written"], $data['fsw_draw'])
        );

        $this->sports = new FSActivitySubject(50, self::$fs_degs_settings["sports"]["fs-percent"]);
        $this->sports->setDegrees(
            new Degree(self::$fs_degs_settings["sports"]["evaluation"], $data['fs_sports'])
        );

        // $this->calcTotal();
    }

    public function getFormalTotal(): Degree
    {
        return $this->formalTotal;
    }

    public function getBaseTotal(): Degree
    {
        return $this->baseTotal;
    }

    public function toArray(): array
    {
        $subjects = [];
        $subjects['studentData'] = $this->getStudentData()->toArray();
        $subjects['arabic'] = $this->getArabicSubject()->toArray();
        $subjects['english'] = $this->getEnglishSubject()->toArray();
        $subjects['arabic'] = $this->getArabicSubject()->toArray();
        $subjects['socials'] = $this->getSocialsSubject()->toArray();
        $subjects['math'] = $this->getMathSubject()->toArray();
        $subjects['sciences'] = $this->getSciencesSubject()->toArray();
        //todo  base total code
        $subjects['activity_1'] = $this->getActivity_1()->toArray();
        $subjects['activity_2'] = $this->getActivity_2()->toArray();
        //todo  formal total code
        $subjects['religion'] = $this->getReligionSubject()->toArray();
        $subjects['computer'] = $this->getComputerSubject()->toArray();
        $subjects['draw'] = $this->getDrawSubject()->toArray();
        $subjects['sports'] = $this->getSports()->toArray();
        //todo  student state code
        return $subjects;
    }
}
