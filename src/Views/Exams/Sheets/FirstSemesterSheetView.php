<?php

namespace SM\Views\Exams\Sheets;

use Simple\Core\View;

class FirstSemesterSheetView implements
    ISheetView
{
    private string $template;
    private ?array $context;

    public function __construct(?array $params)
    {
        $this->template = 'exams/fs-sheet/fs-sheet.twig';
    }

    public function load(array $context)
    {
        $this->setEntities($context);
        return View::load($this->template, $this->context);
    }

    public function setEntities(array $entities)
    {
        $data = array_map(function ($item) {
            return $item->toArray();
        }, $entities);
        $this->context['entities'] = $data;
    }
}
