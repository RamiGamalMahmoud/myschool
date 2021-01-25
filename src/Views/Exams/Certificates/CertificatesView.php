<?php

namespace SM\Views\Exams\Certificates;

use Exception;
use Simple\Core\View;
use SM\Views\Helpers\Grade;
use SM\Views\Helpers\Semester;

class CertificatesView
{
    private string $template;
    private ?array $context;

    public function __construct(string $semester, int $gradeNumber)
    {
        $certificateHeader = [
            'semester' => Semester::semesterName($semester),
            'gradeName' => Grade::gradeName($gradeNumber),
            'schoolYear' => '2020 / 2021'
        ];

        $this->context['certificateHeader'] = $certificateHeader;
        if ($semester === 'fs' || $semester === 'ss') {
            $this->template = 'exams/certificates/certificates.twig';
        } else {
            throw new Exception('Semester Error');
        }
    }

    public function render(array $context)
    {
        $this->setEntities($context);
        View::render($this->template, $this->context);
    }

    public function setEntities(array $entities)
    {
        $data = array_map(function ($item) {
            return $item->toArray();
        }, $entities);
        $this->context['entities'] = $data;
    }
}
