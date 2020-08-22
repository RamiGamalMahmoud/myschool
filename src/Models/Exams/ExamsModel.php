<?php

namespace SM\Models\Exams;

use SM\Models\IModel;
use Simple\Helpers\DB;

class ExamsModel implements IModel
{
    private DB $db;
    private $datatable = [

        'evaluation' => [
            'fs' => 'first_semester_evaluation',
            'ss' => 'second_semester_evaluation'
        ],

        'practical' => [
            'fs' => 'first_semester_practical',
            'ss' => 'second_semester_practical'
        ],

        'written' => [
            'fs' => 'first_semester_written',
            'ss' => 'second_semester_written'
        ]
    ];

    public function __construct()
    {
        $this->db = new DB();
    }

    public function insert($argv = [])
    {
    }

    public function delete($argv = [])
    {
    }

    /**
     * Read a monitoring table
     * @param array $argv [gradeNumber, dataTable, semester]
     * @return array|bool
     */
    public function read($argv = [])
    {
        $grade = $argv['gradeNumber'];
        $monitoringType = $argv['dataTable'];
        $datatable = $this->datatable[$argv['dataTable']][$argv['semester']];

        switch ($monitoringType) {
            case 'evaluation':
                return $this->readEvaluation($datatable, $grade);

            case 'practical':
                return $this->readPractical($datatable, $grade);

            case 'written':
                return $this->readWritten($datatable, $grade);
        }
        return false;
    }

    /**
     * Update student degrees in the selected monirotring table
     * @param array $argv holds the requiring data [table, studentId, dataName, datavalue]
     * @return bool
     */
    public function update($argv = [])
    {
        $table = $this->datatable[$argv['dataTable']][$argv['semester']] ?? false;
        $studentId = $argv['studentId'] ?? false;
        $dataName  = $argv['dataName'] ?? false;
        $dataValue = $argv['dataValue'];

        if (!($table && $studentId && $dataName)) {
            return false;
        }

        $dataValue = is_numeric($dataValue) ? $dataValue : '-1';
        // Check if there is alredy record exists in the monitoring table
        if (!$this->recordExists($table, $studentId)) {

            // If not then create it
            $this->createEmptyRecord($table, $studentId);
        }

        // Finaly update the desired column
        $this->db->update($table)
            ->set([$dataName], [$dataValue])
            ->where('studentId', '=', $studentId)
            ->run();
        // And print the value to the user
        echo $dataValue;
    }

    private function recordExists($table, $studentId)
    {
        $count = $this->db->count('studentId')
            ->from($table)
            ->where('studentId', '=', $studentId)
            ->fetchFirst()['count'];

        return $count > 0;
    }

    /**
     * Create an empty record in a monitoring table with the studentId
     * @param string $tableName
     * @param string $studentId
     * @return bool
     */
    private function createEmptyRecord($tableName, $studentId)
    {
        $fieldsNames = $this->db->getFields($tableName);
        $values = [];
        foreach ($fieldsNames as $field) {
            $values[] = null;
        }
        $values[0] = $studentId;

        return $this->db->insertInto($tableName, $fieldsNames)
            ->values($values)->run();
    }

    /**
     * read the evaluation table
     * @param $datatable the table name
     * @param $grade the grade number
     * @return array
     */
    private function readEvaluation($datatable, $grade)
    {
        $fields = [
            'students_data.studentId',
            'students_data.studentId AS sittingNumber',
            'students_data.studentName',
            'students_data.classNumber',
            $datatable . '.arabic',
            $datatable . '.english',
            $datatable . '.socialStudies',
            $datatable . '.math',
            $datatable . '.sciences',
            $datatable . '.activity_1',
            $datatable . '.activity_2',
            $datatable . '.religion',
            $datatable . '.computer',
            $datatable . '.draw',
            $datatable . '.sports'
        ];

        return $this->db->select($fields)
            ->from('students_data')
            ->leftJoin($datatable)
            ->on('students_data.studentId', $datatable . '.studentId')
            ->where('students_data.grade', '=', $grade)
            ->fetch();
    }

    /**
     * read the practical table
     * @param $datatable the table name
     * @param $grade the grade number
     * @return array
     */
    private function readPractical($datatable, $grade)
    {
        $fields = [
            'students_data.studentId',
            'students_data.studentId AS sittingNumber',
            'students_data.studentName',
            'students_data.classNumber',
            $datatable . '.sciences',
            $datatable . '.computer'
        ];
        return $this->db->select($fields)
            ->from('students_data')
            ->leftJoin($datatable)
            ->on('students_data.studentId', $datatable . '.studentId')
            ->where('students_data.grade', '=', $grade)
            ->fetch();
    }

    /**
     * read the written table
     * @param $datatable the table name
     * @param $grade the grade number
     * @return array
     */
    private function readWritten($datatable, $grade)
    {
        $fields = [
            'students_data.studentId',
            'students_data.studentId AS sittingNumber',
            'students_data.studentName',
            'students_data.classNumber',
            $datatable . '.arabic',
            $datatable . '.english',
            $datatable . '.socialStudies',
            $datatable . '.aljebra',
            $datatable . '.geometry',
            $datatable . '.sciences',
            $datatable . '.religion',
            $datatable . '.computer',
            $datatable . '.draw'
        ];

        return $this->db->select($fields)
            ->from('students_data')
            ->leftJoin($datatable)
            ->on('students_data.studentId', $datatable . '.studentId')
            ->where('students_data.grade', '=', $grade)
            ->fetch();
    }
}
