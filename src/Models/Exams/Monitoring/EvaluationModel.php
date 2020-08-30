<?php

namespace SM\Models\Exams\Monitoring;

use Simple\Helpers\DB;
use SM\Entities\Exams\Evaluation;

class EvaluationModel implements IMonitoringModel
{
    /**
     * @var string $dataTable The database table
     */
    private string $dataTable;
    private DB $db;

    public function __construct(string $semester, DB $db)
    {
        $this->db = $db;
        $this->dataTable = $semester === 'fs' ? 'first' : 'second';
        $this->dataTable .= '_semester_evaluation';
    }

    public function fetchAll($gradeNumber)
    {
        $fields = [
            'students_data.studentId',
            'students_data.studentId AS sittingNumber',
            'students_data.studentName',
            'students_data.classNumber',
            $this->dataTable . '.arabic',
            $this->dataTable . '.english',
            $this->dataTable . '.socialStudies',
            $this->dataTable . '.math',
            $this->dataTable . '.sciences',
            $this->dataTable . '.activity_1',
            $this->dataTable . '.activity_2',
            $this->dataTable . '.religion',
            $this->dataTable . '.computer',
            $this->dataTable . '.draw',
            $this->dataTable . '.sports'
        ];

        $entities = $this->db->select($fields)
            ->from('students_data')
            ->leftJoin($this->dataTable)
            ->on('students_data.studentId', $this->dataTable . '.studentId')
            ->where('students_data.grade', '=', $gradeNumber)
            ->fetchObject(Evaluation::class);
        return $entities;
    }

    /**
     * save check if the record is exists if true it updates it or create one and insert it
     * @param object $data
     */
    public function saveMonitoredDegree($data)
    {
        if ($this->isMonotringRecordExists($this->dataTable, 'studentId', $data->id)) {
            return $this->update($data);
        } else {
            $entity = new Evaluation();
            $entity->studentId = $data->id;
            $entity->{$data->dataName} = $data->dataValue;
            return $this->insert($entity);
        }
    }

    private function insert($entity)
    {
        $object_vars = get_object_vars($entity);
        $fields = array_keys($object_vars);
        $values = array_values($object_vars);

        $result = $this->db->insertInto($this->dataTable, $fields)->values($values)->run();
        return $result;
    }

    private function update($data)
    {
        $result = $this->db->update($this->dataTable)
            ->set([$data->dataName], [$data->dataValue])
            ->where('studentid', '=', $data->id)
            ->run();

        return $result;
    }

    /**
     * isMonotringRecordExists check if the record is exists in the database
     * @param string $table the database table
     * @param string $field the database table column to search
     * @param mixed $value the value for search
     */
    private function isMonotringRecordExists(string $table, string $field, $value)
    {
        $isExists = $this->db->count($field)
            ->from($table)
            ->where($field, '=', $value)
            ->fetchFirst()['count'];

        return $isExists > 0;
    }
}
