<?php

namespace SM\Repos\Exams\Sheets;

interface IFirstSemesterSheetRepo
{
    function getAll(): array;
    function getById($id): array;
    public function getPassedStudents(): array;
    public function getFailedStudents(): array;
}
