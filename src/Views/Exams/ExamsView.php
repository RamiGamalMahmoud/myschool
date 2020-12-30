<?php

namespace SM\Views\Exams;

use Simple\Core\View;

class ExamsView
{
    private string $template;
    private ?array $context;

    private function getGradeName(int $gradeNumber)
    {
        $gradeNames = [
            1 => 'الصف الأول',
            2 => 'الصف الثاني',
            3 => 'الصف الثالث'
        ];
        return $gradeNames[$gradeNumber];
    }

    public function __construct(?array $params)
    {
        $this->context = $params;
        $this->template = 'exams/exams.twig';

        if ($params === null) {
            $this->context['linkPrefex'] = '/exams';
            $this->context['parentTemplate'] = 'base.twig';
        } else {
            $this->context['linkPrefex'] = $params['linkPrefex'] . '/exams';
        }
    }

    public function setContextItem($item, $value)
    {
        $this->context[$item] = $value;
    }

    public function render()
    {
        View::render($this->template, $this->context);
    }
}
