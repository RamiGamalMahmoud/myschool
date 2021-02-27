<?php

namespace SM\Views\StudentsAffairs;

use Simple\Helpers\Log;
use SM\Views\BaseView;

class StudentsAffairsView extends BaseView
{
    private string $studentsTable = 'students-affairs/students-table/students-table.twig';

    private string $absenceTable = 'students-affairs/absence-table/absence-table.twig';

    public function __construct(array $contextData = [])
    {
        $this->template = 'students-affairs/main.twig';
        $this->contextData = $contextData;
    }

    public function showStudentsTable(array $students)
    {
        $this->addToContextData('students', $students);
        $this->template = $this->studentsTable;
        $this->render();
    }

    public function showAbsenceTable(array $data)
    {
        $this->addToContextData('students', $data);
        $this->template = $this->absenceTable;
        $this->render();
    }
}
