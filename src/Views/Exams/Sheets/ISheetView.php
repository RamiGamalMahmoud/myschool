<?php

namespace SM\Views\Exams\Sheets;

interface ISheetView
{
    function __construct(?array $params);
    function load(array $context);
    function setEntities(array $entities);
}
