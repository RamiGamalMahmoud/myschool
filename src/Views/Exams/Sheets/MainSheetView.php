<?php

namespace SM\Views\Exams\Sheets;

use Simple\Core\View;
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
        $entities = array_map(function ($entity) {
            $translated['studentData']  = $this->translateStudentData($entity->getStudentData()->toArray());
            $translated['arabic'] = $this->translateSubjet($entity->getArabicSubject()->toArray());
            $translated['english'] = $this->translateSubjet($entity->getEnglishSubject()->toArray());
            $translated['socials'] = $this->translateSubjet($entity->getSocialsSubject()->toArray());
            $translated['math'] = $this->translateMathSubject($entity->getMathSubject()->toArray());
            $translated['sciences'] = $this->translatePracticalSubject($entity->getSciencesSubject()->toArray());
            $translated['studentState'] = $this->translateStudentState($entity->getStudentState()->toArray());
            $translated['baseTotal'] = $this->translateTotal($entity->getBaseTotal()->toArray());
            $translated['activity_1'] = $this->translateActivity($entity->getActivity_1()->toArray());
            $translated['activity_2'] = $this->translateActivity($entity->getActivity_2()->toArray());
            $translated['sports'] = $this->translateActivity($entity->getSportsSubject()->toArray());
            $translated['overallTotal'] = $this->translateTotal($entity->getOverallTotal()->toArray());
            $translated['religion'] = $this->translateSubjet($entity->getReligionSubject()->toArray());
            $translated['computer'] = $this->translatePracticalSubject($entity->getComputerSubject()->toArray());
            $translated['draw'] = $this->translateSubjet($entity->getDrawSubject()->toArray());
            return $translated;
        }, $data);
        $this->context['entities'] = $entities;
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

    private function translateActivity(array $activity): array
    {
        $result = [
            'fs' => $this->translateDegree($activity['fs']),
            'ss' => $this->translateDegree($activity['ss']),
            'subjectResult' => $this->translateSubjectResult($activity['subjectResult'])
        ];
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

        $subjects = implode(' | ', $weaknessSubjects);

        $result = [
            'isPassed' => $isPassed,
            'state' => Translate::getStudentState($studentState['state'], 'ss'),
            'weaknessSubjects' => $subjects
        ];
        return $result;
    }

    private function translateDegree(array $degree): array
    {
        $isAbsence = $degree['isAbsence'];
        if ($isAbsence) {
            $value = Translate::getStudentGrade('ABS');
        } else {
            $value = Numbers::convertNumbers($degree['value']);
        }
        $result = [
            'isAbsence' => $isAbsence,
            'value' => $value
        ];
        return $result;
    }

    private function translateStudentGrade(array $grade): array
    {
        $isPassed = $grade['value'] !== 'F';
        $result = [
            'isPassed' => $isPassed,
            'isAbsence' => $grade['isAbsence'],
            'value' => Translate::getStudentGrade($grade['value'])
        ];
        return $result;
    }

    private function translateTotal(array $total): array
    {
        $result = [
            'total' => $this->translateDegree($total['total']),
            'grade' => $this->translateStudentGrade($total['grade'])
        ];
        return $result;
    }

    private function translateSubjectResult(array $subjectResult): array
    {
        $result = [
            'total' => $this->translateDegree($subjectResult['total']),
            'netDegree' => $this->translateDegree($subjectResult['netDegree']),
            'grade' => $this->translateStudentGrade($subjectResult['grade'])
        ];
        return $result;
    }
}
