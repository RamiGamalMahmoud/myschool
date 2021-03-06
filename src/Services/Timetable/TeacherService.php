<?php

namespace SM\Services\Timetable;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Helpers\Log;
use SM\Entities\Timetable\Teacher;
use SM\Repos\Timetable\ITeacherRepo;
use SM\Repos\Timetable\TeacherRepo;
use SM\Services\Facades\ClassroomService;
use SM\Services\Facades\SubjectService;

class TeacherService
{
    private ITeacherRepo $teacherRepo;

    public function __construct()
    {
        $this->teacherRepo = new TeacherRepo(new MySQLAccess());
    }

    public function getAllTeachers()
    {
        $data = $this->teacherRepo->getAllTeachers();

        $teachers = array_map(function ($teacher) {
            return $this->preapareTeacherData($teacher);
        }, $data);
        return $teachers;
    }

    public function updateTeacherClassrooms($teacherId, $classrooms)
    {
        $classrooms = array_reduce($classrooms, function ($acc, $classroom) {
            $parts = preg_split("/-/", $classroom);
            $acc[$parts[0]][] = $parts[1];
            return $acc;
        }, []);
        foreach ($classrooms as $subjectId => $classroomsIds) {
            if (count($classroomsIds) === 1 && $classroomsIds[0] === 'clear') {
                $this->teacherRepo->updateClassrooms($teacherId, $subjectId, null);
            } else {
                $this->teacherRepo->updateClassrooms($teacherId, $subjectId, json_encode($classroomsIds));
            }
        }
    }

    /**
     * @param int $id
     * @return \SM\Entities\Timetable\Teacher
     */
    public function getTeacher($id): Teacher
    {
        return $this->preapareTeacherData($this->teacherRepo->getTeacherById($id));
    }

    private function preapareTeacherData($teacherData)
    {
        $subjects = $this->extractIdsFromJson($teacherData['classrooms']);
        $teachingClassrooms = $this->createSubjectsClassrooms($subjects);
        $subject = SubjectService::getSubjectById($teacherData['specialization_id']);
        $teacher = new Teacher(
            $teacherData['id'],
            $teacherData['name'],
            $teachingClassrooms,
            $subject,
            $teacherData['quorum']
        );
        return $teacher;
    }

    private function extractIdsFromJson($jsonData): array
    {
        $subjects = [];
        $_subjects = json_decode('[' . $jsonData . ']');
        foreach ($_subjects as $subject) {
            $subject = (array)$subject;
            $subjectId = array_keys($subject)[0];
            $classrooms = json_decode(array_values($subject)[0]);
            $subjects[$subjectId] = $classrooms;
        }
        return $subjects;
    }

    private function createSubjectsClassrooms($subjectsArray)
    {

        $teachingClassrooms = [];
        foreach ($subjectsArray as $subjectId => $classroomsIds) {
            $teachingClassrooms[$subjectId]['subject'] = SubjectService::getSubjectById($subjectId);
            $teachingClassrooms[$subjectId]['classrooms'] = $classroomsIds ? array_map(function ($classroomId) {
                return ClassroomService::getClassroomById($classroomId);
            }, $classroomsIds) : null;
        }
        return $teachingClassrooms;
    }
}
