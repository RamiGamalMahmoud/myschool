<?php

namespace SM\Views\Exams\Sheets;

interface ISheetView
{
    function __construct(int $gradeNumber);
    function render(array $context);
    function setEntities(array $entities);
}
