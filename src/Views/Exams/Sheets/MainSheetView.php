<?php

namespace SM\Views\Exams\Sheets;

use Simple\Core\View;
use Simple\Helpers\Functions;
use SM\Entities\Exams\Sheets\MainSheetEntity;
use SM\Helpers\Numbers;
use SM\Helpers\Translate;

class MainSheetView implements
    ISheetView
{
    private string $template;
    private ?array $context;

    public function __construct(?array $params)
    {
        $this->template = 'exams/sheets/main-sheet/main-sheet.twig';
    }
    public function load(array $context)
    {
        $this->setEntities($context);
        return View::load($this->template, $this->context);
    }

    public function setEntities(array $data)
    {
        // Functions::dump($data[0]->toArray());
        // exit;
        $entities = array_map(function ($entity) {
            $translated['studentData']  = $this->translateStudentData($entity->getStudentData()->toArray());
            $translated['arabic'] = $this->translateSubjet($entity->getArabicSubject()->toArray());
            $translated['english'] = $this->translateSubjet($entity->getEnglishSubject()->toArray());
            $translated['socials'] = $this->translateSubjet($entity->getSocialsSubject()->toArray());
            $translated['math'] = $this->translateMathSubject($entity->getMathSubject()->toArray());
            $translated['sciences'] = $this->translatePracticalSubject($entity->getSciencesSubject()->toArray());
            $translated['studentState'] = $this->translateStudentState($entity->getStudentState()->toArray());

            $translated['religion'] = $this->translateSubjet($entity->getReligionSubject()->toArray());
            $translated['computer'] = $this->translatePracticalSubject($entity->getComputerSubject()->toArray());
            $translated['draw'] = $this->translateSubjet($entity->getDrawSubject()->toArray());
            return $translated;
            // return $entity->toArray();
        }, $data);
        $this->context['entities'] = $entities;
    }

    private function getObject($item): MainSheetEntity
    {
        return $item;
    }

    private function translateStudentData($data): array
    {
        $result['studentId'] = Numbers::convertNumbers($data['studentId']);
        $result['sittingNumber'] = Numbers::convertNumbers($data['sittingNumber']);
        $result['studentName'] = Numbers::convertNumbers($data['studentName']);
        $result['classNumber'] = Numbers::convertNumbers($data['classNumber']);
        $result['gradeNumber'] = Numbers::convertNumbers($data['gradeNumber']);
        $result['sex'] = Numbers::convertNumbers($data['sex']);
        $result['enrollmentStatus'] = Numbers::convertNumbers($data['enrollmentStatus']);
        $result['religion'] = Numbers::convertNumbers($data['religion']);
        $result['pirthDate'] = Numbers::convertNumbers($data['pirthDate']);
        $result['pirthDay'] = Numbers::convertNumbers($data['pirthDay']);
        $result['pirthMonth'] = Numbers::convertNumbers($data['sittingNumber']);
        $result['pirthYear'] = Numbers::convertNumbers($data['pirthYear']);
        $result['firstSemesterSecretNumber'] = Numbers::convertNumbers($data['firstSemesterSecretNumber']);
        $result['secondSemesterSecretNumber'] = Numbers::convertNumbers($data['secondSemesterSecretNumber']);
        return $result;
    }

    private function translateSubjet(array $subject): array
    {
        $result = [
            'fs' => [
                'evaluation' => $this->translateDegree($subject['fs']['evaluation']),
                'written' => $this->translateDegree($subject['fs']['written'])
            ],
            'ss' => [
                'evaluation' => $this->translateDegree($subject['ss']['evaluation']),
                'written' => $this->translateDegree($subject['ss']['written'])
            ],
            'subjectResult' => $this->translateSubjectResult($subject['subjectResult'])
        ];
        return $result;
    }

    private function translateMathSubject(array $subject): array
    {
        $result = [
            'fs' => [
                'evaluation' => $this->translateDegree($subject['fs']['evaluation']),
                'aljebra' => $this->translateDegree($subject['fs']['aljebra']),
                'geometry' => $this->translateDegree($subject['fs']['geometry']),
                'written' => $this->translateDegree($subject['fs']['written'])
            ],
            'ss' => [
                'evaluation' => $this->translateDegree($subject['ss']['evaluation']),
                'aljebra' => $this->translateDegree($subject['ss']['aljebra']),
                'geometry' => $this->translateDegree($subject['ss']['geometry']),
                'written' => $this->translateDegree($subject['ss']['written'])
            ],
            'subjectResult' => $this->translateSubjectResult($subject['subjectResult'])
        ];
        return $result;
    }

    private function translatePracticalSubject(array $subject): array
    {
        $result = [
            'fs' => [
                'evaluation' => $this->translateDegree($subject['fs']['evaluation']),
                'practicalExam' => $this->translateDegree($subject['fs']['practicalExam']),
                'writtenExam' => $this->translateDegree($subject['fs']['writtenExam']),
                'written' => $this->translateDegree($subject['fs']['written'])
            ],
            'ss' => [
                'evaluation' => $this->translateDegree($subject['ss']['evaluation']),
                'practicalExam' => $this->translateDegree($subject['ss']['practicalExam']),
                'writtenExam' => $this->translateDegree($subject['ss']['writtenExam']),
                'written' => $this->translateDegree($subject['ss']['written'])
            ],
            'subjectResult' => $this->translateSubjectResult($subject['subjectResult'])
        ];
        return $result;
    }

    private function translateStudentState(array $studentState): array
    {
        $isPassed = $studentState['state'] === 'PASSED';
        $weaknessSubjects = array_map(function ($subject) {
            return Translate::getSubjectName($subject);
        }, $studentState['weaknessSubjects']);

        $result = [
            'isPassed' => $isPassed,
            'state' => Translate::getStudentState($studentState['state'], 'ss'),
            'weaknessSubjects' => $weaknessSubjects
        ];
        return $result;
    }

    private function translateDegree(array $degree): array
    {
        $result = [
            'isAbsence' => $degree['isAbsence'],
            'value' => Numbers::convertNumbers($degree['value'])
        ];
        return $result;
    }

    private function translateStudentGrade(array $grade): array
    {
        $isPassed = $grade['value'] === 'F';
        $result = [
            'isPassed' => $isPassed,
            'isAbsence' => $grade['isAbsence'],
            'value' => Translate::getStudentGrade($grade['value'])
        ];
        return $result;
    }

    private function translateSubjectResult(array $subjectResult): array
    {
        $result = [];
        $result['total'] = $this->translateDegree($subjectResult['total']);
        $result['netDegree'] = $this->translateDegree($subjectResult['netDegree']);
        $result['grade'] = $this->translateStudentGrade($subjectResult['grade']);
        return $result;
    }
}
