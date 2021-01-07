<?php

namespace SM\Views\Exams\Sheets;

use Simple\Core\View;
use Simple\Helpers\Functions;
use SM\Entities\Exams\Sheets\MainSheetEntity;
use SM\Helpers\Numbers;

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

    public function setEntities(array $entities)
    {
        $data = array_map(function ($item) {
            $i = $this->getObject($item);
            $result['studentData'] = $this->translateStudentData($i->getStudentData()->toArray());
            $result['arabic'] = $this->translateSubjet($i->getArabicSubject()->toArray());

            return $result;
            // return $item->toArray();
        }, $entities);
        Functions::dump($data);
        exit;
        $this->context['entities'] = $data;
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

    private function translateDegree(array $data): array
    {
        $result = [
            'isAbsence' => '',
            'value' => 'f'
        ];
        return $result;
    }

    private function translateSubjet(array $data): array
    {
        $result = [
            'fs' => [
                'evaluation' => $this->translateDegree($data['fs']['evaluation']),
                'written' => $this->translateDegree($data['fs']['written'])
            ]
        ];
        return $result;
    }
}
