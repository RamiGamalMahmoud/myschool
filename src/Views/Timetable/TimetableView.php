<?php

namespace SM\Views\Timetable;

use Simple\Core\View;
use SM\Views\BaseView;

class TimetableView extends BaseView
{
    public function __construct(array $contenxtData = [])
    {
        $this->template = 'timetable/main.twig';
        $this->contextData = $contenxtData;
    }

    public function showTeachersTable(array $teachers, $grades)
    {
        $this->template = 'timetable/teacher-table/teacher-table.twig';
        $this->addToContextData('teachers', $teachers);
        $this->render();
    }

    public function showEditTeacherForm($teacher)
    {
        $this->template = 'timetable/edit-teacher-classrooms/edit-teacher.twig';
        $this->addToContextData('teacher', $teacher);
        $this->render();
    }

    public function showMainTable()
    {
        $this->template = 'timetable/timetable/main-table/main-table.twig';
        $this->render();
    }

    public function showDayTimetable()
    {
        $this->template = 'timetable/timetable/day-table/day-table.twig';
        $this->render();
    }
}
