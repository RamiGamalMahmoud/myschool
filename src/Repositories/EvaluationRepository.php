<?php

namespace SM\Repositories;

use Simple\Helpers\DB;
use SM\Entities\BaseEntity;

class EvaluationRepository extends BaseRepository
{

    public function __construct(string $semester)
    {
        $this->db = new DB();
        $semester = $semester === 'fs' ? 'first' : 'second';
        $this->table = $semester . '_semester_evaluation';

        $this->fields = [
            'students_data.studentId',
            'students_data.studentId AS sittingNumber',
            'students_data.studentName',
            'students_data.classNumber',
            $this->table . '.arabic',
            $this->table . '.english',
            $this->table . '.socialStudies',
            $this->table . '.math',
            $this->table . '.sciences',
            $this->table . '.activity_1',
            $this->table . '.activity_2',
            $this->table . '.religion',
            $this->table . '.computer',
            $this->table . '.draw',
            $this->table . '.sports'
        ];
    }
    public function fetch($grade): array
    {
        $entities = $this->db->select($this->fields)
            ->from('students_data')
            ->leftJoin($this->table)
            ->on('students_data.studentId', $this->table . '.studentId')
            ->where('students_data.grade', '=', $grade)
            ->fetchObject('SM\Entities\EvaluationEntity');
        return $entities;
    }

    /**
     * Will be used in search
     */
    public function findById($id)
    {
        echo $this->table;
        $query = $this->db->select($this->fields)
            ->from('students_data')
            ->leftJoin($this->table)
            ->on('students_data.studentId', $this->table . '.studentId')
            ->where($this->table . '.studentId', '=', $id)
            ->fetchFirst();
        return $query;
    }

    public function exists($id)
    {
        $query = $this->db->count('studentId')
        ->from($this->table)
        ->where('studentId', '=', $id);
        return $query->fetchFirst()['count'] > 0;
    }

    public function save(BaseEntity $e)
    {
        $props = $e->getProps();
        $fields = array_keys($props);
        $values = array_values($props);

        $query = $this->db->insertInto($this->table,$fields)
        ->values($values)->run();
        
    }

    public function update(BaseEntity $e, string $dataName)
    {
        // IF THE OBJECT IS EXISTS UPDATE ITS DATANAME
        // ELSE INSERT IT
        if(!$this->exists($e->studentId)){
            $this->save($e);
        } else {
            $this->db->update($this->table)
            ->set([$dataName], [$e->{$dataName}])
            ->where('studentId', '=', $e->studentId)
            ->run();
        }
        echo  $e->{$dataName};
    }

    public function remove(BaseEntity $e)
    {
    }
}
