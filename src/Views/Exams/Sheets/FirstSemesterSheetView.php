<?php

namespace SM\Views\Exams\Sheets;

use Simple\Core\View;
use Simple\Helpers\Functions;

class FirstSemesterSheetView
{
    private string $template;
    private ?array $context;

    public function __construct(string $sheetType, ?array $params)
    {
        if ($sheetType === 'fs') {
            $this->template = 'exams/fs-sheet/fs-sheet.twig';
        } elseif ($sheetType === 'ss') {
            $this->template = 'exams/ss-sheet/ss-sheet.twig';
        } else {
            //! ERROR
        }
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
