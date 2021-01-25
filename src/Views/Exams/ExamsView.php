<?php

namespace SM\Views\Exams;

use Simple\Core\View;

class ExamsView
{
    private string $template;
    private ?array $context;

    public function __construct(?array $params)
    {
        $this->context = $params;
        $this->template = 'exams/exams.twig';
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
