<?php

namespace SM\Repos\Exams\Monitoring;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use Simple\Core\Response;
use SM\Entities\Entity;
use SM\Exceptions\ExamsExceptions\DegreeException;
use SM\Exceptions\ExamsExceptions\StudentIdNotFoundException;

abstract class AbstractMonitoringRepo
{

    protected IDataAccess $dataAccess;
    protected string $dbTable;
    protected int $gradeNumber;

    private function isValidId($id): bool
    {
        $query = new Query();
        $query->selectCount('id')
            ->from('students_data')
            ->where('id', '=', $id);
        return $this->dataAccess->get($query)['count'] > 0;
    }

    private function isIdExisted($id)
    {
        $query = new Query();
        $query->selectCount('student_id')
            ->from($this->dbTable)
            ->where('student_id', '=', $id);
        return $this->dataAccess->get($query)['count'] > 0;
    }

    protected function checkDegree(string $type, string $subjectName, float $degree)
    {
        $subjects = [
            'evaluation' => [
                'arabic' => 30,
                'english' => 30,
                'social_studies' => 30,
                'math' => 30,
                'sciences' => 30,
                'activity_1' => 100,
                'activity_2' => 100,
                'religion' => 30,
                'computer' => 30,
                'draw' => 30,
                'sport' => 20
            ],
            'practical' => [
                'sciences' => 14,
                'computer' => 14
            ],
            'written' => [
                'arabic' => 70,
                'english' => 70,
                'social_studies' => 70,
                'aljebra' => 35,
                'geometry' => 35,
                'sciences' => 56,
                'religion' => 70,
                'computer' => 56,
                'draw' => 70,
            ]
        ];
        return $subjects[$type][$subjectName] >= $degree;
    }

    protected abstract function isValidDegree(string $subjectName, float $degree);

    public abstract function __construct(string $semester, int $gradeNumber, IDataAccess $dataAccess);

    public function save($studentId, $subjectName, $degree)
    {

        if ($this->isValidId($studentId)) {

            if (is_null($degree)) {
                return $this->update($studentId, $subjectName, $degree);
            } elseif ($this->isValidDegree($subjectName, $degree)) {

                if ($this->isIdExisted($studentId)) {
                    return $this->update($studentId, $subjectName, $degree);
                } else {
                    return $this->create($studentId, $subjectName, $degree);
                }
            } else {
                throw new DegreeException('Degree is not correct');
            }
        } else {
            throw new StudentIdNotFoundException('Student id not existed');
        }
    }

    public function create($studentId, $subjectName, $degree)
    {
        $query = new Query();
        $query->insertInto($this->dbTable)
            ->values(['student_id' => $studentId, $subjectName => $degree]);
        return $this->dataAccess->run($query);
    }

    public function update($studentId, $subjectName, $degree)
    {
        $query = new Query();
        $query->update($this->dbTable)
            ->set([$subjectName => $degree])
            ->where('student_id', '=', $studentId);
        return $this->dataAccess->run($query);
    }
}
