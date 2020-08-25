<?php

namespace SM\Models\Exams;

use SM\Models\IModel;
use Simple\Helpers\DB;
use SM\Repositories\BaseRepository;
use SM\Repositories\MonitoringRepository;

class ExamsModel implements IModel
{
    private DB $db;
    private $repo;
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
        $grade          = $argv['gradeNumber'];
        $monitoringType = $argv['monitoringType'];
        $semester       = $argv['semester'];

        $this->repo = new MonitoringRepository($monitoringType, $semester);
        return $this->repo->fetch($grade);
        return false;
    }

    /**
     * Update student degrees in the selected monirotring table
     * @param array $argv holds the requiring data [table, studentId, dataName, datavalue]
     * @return bool
     */
    public function update($argv = [])
    {
        $this->repo = new MonitoringRepository($argv['monitoringType'], $argv['semester']);
        $entityClass = 'SM\\Entities\\' . ucfirst($argv['monitoringType']) . 'Entity';

        if (class_exists($entityClass)) {
            $entity = new $entityClass();
            $entity->{$argv['dataName']} = is_numeric($argv['dataValue']) ? $argv['dataValue'] : -1;
            $entity->studentId = $argv['studentId'];
            $this->repo->update($entity, $argv['dataName']);
            return true;
        }
        return false;
    }
}