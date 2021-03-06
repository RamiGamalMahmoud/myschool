<?php

namespace SM\Repos\Exams\Monitoring;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Entities\Exams\PracticalEntity;
use SM\Entities\Exams\WrittenEntity;

class WrittenRepo extends AbstractMonitoringRepo  implements IMonitoringRepo
{
    protected function isValidDegree(string $subjectName, float $degree)
    {
        return $this->checkDegree('written', $subjectName, $degree);
    }

    public function __construct(string $semester, int $gradeNumber, IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->gradeNumber = $gradeNumber;
        $this->dbTable = $semester === 'fs' ? 'first' : 'second';
        $this->dbTable .= '_semester_written';
    }

    public function getAll()
    {
        $columns = [
            'students_data.id',
            'students_data.id AS sitting_number',
            'students_data.name',
            'students_data.class_number',
            $this->dbTable . '.arabic',
            $this->dbTable . '.english',
            $this->dbTable . '.social_studies',
            $this->dbTable . '.aljebra',
            $this->dbTable . '.geometry',
            $this->dbTable . '.sciences',
            $this->dbTable . '.religion',
            $this->dbTable . '.computer',
            $this->dbTable . '.draw'
        ];

        $query = new Query();
        $query->select($columns)
            ->from('students_data')
            ->leftJoin($this->dbTable)
            ->on('students_data.id', $this->dbTable . '.student_id')
            ->where('students_data.grade', '=', $this->gradeNumber);

        $data = $this->dataAccess->getAll($query);
        $entities = [];
        foreach ($data as $entity) {
            array_push($entities, new WrittenEntity($entity));
        }
        return $entities;
    }

    public function getById($id)
    {
    }

    public function remove($id)
    {
    }
}
