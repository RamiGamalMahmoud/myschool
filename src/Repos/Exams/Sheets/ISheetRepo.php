<?php

namespace SM\Repos\Exams\Sheets;

interface ISheetRepo
{
    function getAll(): array;
    function getById($id): array;
    public function getPassedStudents(): array;
    public function getFailedStudents(): array;
}
