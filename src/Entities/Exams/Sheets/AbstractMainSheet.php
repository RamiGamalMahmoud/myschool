<?php

namespace SM\Entities\Exams\Sheets;

use SM\Objects\Exams\Degree;
use SM\Objects\Exams\FullStudentData;
use SM\Objects\Exams\Sheets\SSObjects\FinalSubject;
use SM\Objects\Exams\Sheets\SSObjects\FinalMathSubject;
use SM\Objects\Exams\Sheets\SSObjects\FinalActivitySubject;
use SM\Objects\Exams\Sheets\SSObjects\FinalPracticalSubject;
use SM\Objects\Exams\Sheets\SSObjects\Semester\ActivitySemester;
use SM\Objects\Exams\Sheets\SSObjects\Semester\MathSemester;
use SM\Objects\Exams\Sheets\SSObjects\Semester\PracticalSemester;
use SM\Objects\Exams\Sheets\SSObjects\Semester\Semester;
use SM\Objects\Exams\StudentState;
use SM\Objects\Exams\Total;

abstract class AbstractMainSheet
{
    /**
     * @var array degrees settings
     */
    protected static array $DEGS_SETTINGS;

    protected FullStudentData $_studentData;

    protected FinalSubject $_arabic;
    protected FinalSubject $_english;
    protected FinalSubject $_socials;
    protected FinalMathSubject $_math;
    protected FinalPracticalSubject $_sciences;

    protected FinalActivitySubject $_activity_1;
    protected FinalActivitySubject $_activity_2;

    protected FinalSubject $_religion;
    protected FinalPracticalSubject $_computer;
    protected FinalSubject $_draw;

    protected FinalActivitySubject $_sports;

    protected Total $overallTotal;
    protected Total $baseTotal;
    protected StudentState $studentState;

    protected function init(array $data)
    {
        $this->_studentData = new FullStudentData($data);
        $arabicFS = new Semester(new Degree(30, $data['fse_arabic']), new Degree(70, $data['fsw_arabic']));
        $arabicSS = new Semester(new Degree(30, $data['sse_arabic']), new Degree(70, $data['ssw_arabic']));
        $this->_arabic = new FinalSubject('arabic', $arabicFS, $arabicSS, 21, self::$DEGS_SETTINGS['arabic']['ss-percent']);

        $englishFS = new Semester(new Degree(30, $data['fse_english']), new Degree(70, $data['fsw_english']));
        $englishSS = new Semester(new Degree(30, $data['sse_engligh']), new Degree(70, $data['ssw_english']));
        $this->_english = new FinalSubject('english', $englishFS, $englishSS, 21, self::$DEGS_SETTINGS['english']['ss-percent']);

        $socialsFS = new Semester(new Degree(30, $data['fse_socials']), new Degree(70, $data['fsw_socials']));
        $socialsSS = new Semester(new Degree(30, $data['sse_socials']), new Degree(70, $data['ssw_socials']));
        $this->_socials = new FinalSubject('socials', $socialsFS, $socialsSS, 21, self::$DEGS_SETTINGS['socials']['ss-percent']);

        $mathhFS = new MathSemester(
            new Degree(30, $data['fse_math']),
            new Degree(35, $data['fsw_aljebra']),
            new Degree(35, $data['fsw_geometry'])
        );
        $mathhSS = new MathSemester(
            new Degree(30, $data['sse_math']),
            new Degree(35, $data['ssw_aljebra']),
            new Degree(35, $data['ssw_geometry'])
        );
        $this->_math = new FinalMathSubject('math', $mathhFS, $mathhSS, 21, self::$DEGS_SETTINGS['math']['ss-percent']);

        $sciencesFS = new PracticalSemester(
            new Degree(30, $data['fse_sciences']),
            new Degree(14, $data['fsp_sciences']),
            new Degree(56, $data['fsw_sciences'])
        );
        $sciencesSS = new PracticalSemester(
            new Degree(30, $data['sse_sciences']),
            new Degree(14, $data['ssp_sciences']),
            new Degree(56, $data['ss_sciences'])
        );
        $this->_sciences = new FinalPracticalSubject('sciences', $sciencesFS, $sciencesSS, 21, self::$DEGS_SETTINGS['sciences']['ss-percent']);

        $religionFS = new Semester(new Degree(30, $data['fse_religion']), new Degree(70, $data['fsw_religion']));
        $religionSS = new Semester(new Degree(30, $data['sse_religion']), new Degree(70, $data['ssw_religion']));
        $this->_religion = new FinalSubject('religion', $religionFS, $religionSS, 21, self::$DEGS_SETTINGS['religion']['ss-percent']);

        $activity_1_FS = new ActivitySemester(new Degree(100, $data['fse_activity_1']));
        $activity_1_SS = new ActivitySemester(new Degree(100, $data['sse_activity_1']));
        $this->_activity_1 = new FinalActivitySubject('activity_1', $activity_1_FS, $activity_1_SS, 20);

        $activity_2_FS = new ActivitySemester(new Degree(100, $data['fse_activity_2']));
        $activity_2_SS = new ActivitySemester(new Degree(100, $data['sse_activity_2']));
        $this->_activity_2 = new FinalActivitySubject('activity_2', $activity_2_FS, $activity_2_SS, 20);

        $computerFS = new PracticalSemester(
            new Degree(30, $data['fse_computer']),
            new Degree(14, $data['fsp_computer']),
            new Degree(56, $data['fsw_computer'])
        );
        $computerSS = new PracticalSemester(
            new Degree(30, $data['sse_computer']),
            new Degree(14, $data['ssp_computer']),
            new Degree(56, $data['ss_computer'])
        );
        $this->_computer = new FinalPracticalSubject('computer', $computerFS, $computerSS, 21, self::$DEGS_SETTINGS['computer']['ss-percent']);

        $drawFS = new Semester(new Degree(30, $data['fse_draw']), new Degree(70, $data['fsw_draw']));
        $drawSS = new Semester(new Degree(30, $data['sse_draw']), new Degree(70, $data['ssw_draw']));
        $this->_draw = new FinalSubject('draw', $drawFS, $drawSS, 21, self::$DEGS_SETTINGS['draw']['ss-percent']);

        $sportsFS = new ActivitySemester(new Degree(20, $data['fse_sports']));
        $sportsSS = new ActivitySemester(new Degree(20, $data['sse_sports']));
        $this->_sports = new FinalActivitySubject('sports', $sportsFS, $sportsSS, 100);
    }

    public static function setDegsSettings(array $degsSettings)
    {
        self::$DEGS_SETTINGS = $degsSettings;
    }

    public function getStudentData(): FullStudentData
    {
        return $this->_studentData;
    }

    public function getArabicSubject(): FinalSubject
    {
        return $this->_arabic;
    }

    public function getEnglishSubject(): FinalSubject
    {
        return $this->_english;
    }

    public function getSocialsSubject(): FinalSubject
    {
        return $this->_socials;
    }

    public function getMathSubject(): FinalMathSubject
    {
        return $this->_math;
    }

    public function getSciencesSubject(): FinalPracticalSubject
    {
        return $this->_sciences;
    }

    public function getActivity_1(): FinalActivitySubject
    {
        return $this->_activity_1;
    }

    public function getActivity_2(): FinalActivitySubject
    {
        return $this->_activity_2;
    }

    public function getReligionSubject(): FinalSubject
    {
        return $this->_religion;
    }

    public function getComputerSubject(): FinalPracticalSubject
    {
        return $this->_computer;
    }

    public function getDrawSubject(): FinalSubject
    {
        return $this->_draw;
    }

    public function getSportsSubject(): FinalActivitySubject
    {
        return $this->_sports;
    }

    public function getStudentState(): StudentState
    {
        return $this->studentState;
    }
}
