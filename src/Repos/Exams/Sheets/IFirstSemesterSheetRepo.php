<?php

namespace SM\Repos\Exams\Sheets;

interface IFirstSemesterSheetRepo
{
    function getAll();
    function getById($id);
}
