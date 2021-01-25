<?php

namespace SM\Views\Exams\Sheets;

use Simple\Core\View;

class FirstSemesterSheetView implements
    ISheetView
{
    private string $template;
    private ?array $context;

    public function __construct(int $gradeNumber)
    {
        $this->template = 'exams/sheets/fs-sheet/fs-sheet.twig';
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
