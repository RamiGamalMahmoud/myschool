<?php

namespace SM\Repositories;

use Simple\Helpers\DB;
use SM\Entities\BaseEntity;

class MonitoringRepository extends BaseRepository implements IReadRepository, IWriteRepository
{
    protected $entityClass;

    public function __construct(string $monitoringType, string $semester)
    {
        $this->db = new DB();
        $semester = $semester === 'fs' ? 'first' : 'second';
        $this->table = $semester . '_semester_' . $monitoringType;
        $allFields = $this->getFields($monitoringType);

        $monitoringFields = $allFields['tableFields'];

        $monitoringFields = array_map(function ($item) {
            return $this->table . '.' . $item;
        }, $monitoringFields);

        $this->fields = array_merge($monitoringFields, $allFields['studentsDataFields']);

        $this->entityClass = 'SM\\Entities\\' . ucfirst($monitoringType) . 'Entity';
    }

    public function fetch($grade): array
    {
        $entities = $this->db->select($this->fields)
            ->from('students_data')
            ->leftJoin($this->table)
            ->on('students_data.studentId', $this->table . '.studentId')
            ->where('students_data.grade', '=', $grade)
            ->fetchObject($this->entityClass);
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

        $this->db->insertInto($this->table, $fields)
            ->values($values)->run();
    }

    public function update(BaseEntity $e, string $dataName)
    {
        // IF THE OBJECT IS EXISTS UPDATE ITS DATANAME
        // ELSE INSERT IT
        if (!$this->exists($e->studentId)) {
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

    private function getFields(string $monitoringTable)
    {
        $fields = [
            'evaluation' => [
                'tableFields'        => ['arabic', 'english', 'socialStudies', 'math', 'sciences', 'activity_1', 'activity_2', 'religion', 'computer', 'draw', 'sports'],
                'studentsDataFields' => ['students_data.studentId', 'students_data.studentId AS sittingNumber', 'students_data.studentName', 'students_data.classNumber']
            ],
            'practical' => [
                'tableFields'        => ['sciences', 'computer'],
                'studentsDataFields' => ['students_data.studentId', 'students_data.studentId AS sittingNumber', 'students_data.studentName', 'students_data.classNumber']
            ],
            'written' => [
                'tableFields'        => ['arabic', 'english', 'socialStudies', 'aljebra', 'geometry', 'sciences', 'religion', 'computer', 'draw'],
                'studentsDataFields' => ['students_data.studentId', 'students_data.studentId AS sittingNumber', 'students_data.studentName', 'students_data.classNumber']
            ]
        ];

        return $fields[$monitoringTable];
    }
}
