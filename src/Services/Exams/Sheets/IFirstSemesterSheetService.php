<?php

namespace SM\Services\Exams\Sheets;

interface IFirstSemesterSheetService
{
    public function getAll();
    public function getById(int $id);
}
