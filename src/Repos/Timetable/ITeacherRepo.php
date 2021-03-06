<?php

namespace SM\Repos\Timetable;

interface ITeacherRepo
{
    public function getAllTeachers(): array;
    public function getTeacherById($id);
    public function updateClassrooms(int $teacherId, $subjectId, $classrooms);
}
