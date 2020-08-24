<?php

namespace SM\Models\Exams;

use InvalidArgumentException;
use SM\Repositories\EvaluationRepository;
use SM\Models\IModel;
use Simple\Helpers\DB;
use SM\Repositories\BaseRepository;

class ExamsModel implements IModel
{
    private DB $db;
    private BaseRepository $repo;
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
        // monitoringType, grade, semester
        // Functions::dump($argv); exit();
        $grade = $argv['gradeNumber'];
        $monitoringType = $argv['dataTable'];
        $this->semester = $argv['semester'];

        $method = 'read' . ucfirst($monitoringType);
        if (method_exists(self::class, $method)) {
            return call_user_func([$this, $method], $grade);
        }
        switch ($monitoringType) {
            case 'evaluation':
                // get the evaluatin repo
                return $this->readEvaluation($grade);
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
        $repoClass = 'SM\\Repositories\\';
        $repoClass .= ucfirst($argv['monitoringType']) . 'Repository';
        $entityClass = 'SM\\Entities\\' . ucfirst($argv['monitoringType']) . 'Entity';

        if(class_exists($repoClass) && class_exists($entityClass)){
            $this->repo = new $repoClass($argv['semester']);
            $entity = new $entityClass();
            $entity->{$argv['dataName']} = $argv['dataValue'];
            $entity->studentId = $argv['studentId'];
            $this->repo->update($entity, $argv['dataName']);
        } else {
            throw new InvalidArgumentException('student not found');
        }
    }

    /**
     * read the evaluation table
     * @param $datatable the table name
     * @param $grade the grade number
     * @return array
     */
    private function readEvaluation($grade)
    {
        $repo = new EvaluationRepository($this->semester);
        return $repo->fetch($grade);
    }

    /**
     * read the practical table
     * @param $datatable the table name
     * @param $grade the grade number
     * @return array
     */
    private function readPractical($datatable, $grade)
    {
        $repo = new EvaluationRepository($this->semester);
        return $repo->fetch($grade);
    }

    /**
     * read the written table
     * @param $datatable the table name
     * @param $grade the grade number
     * @return array
     */
    private function readWritten($datatable, $grade)
    {
        $repo = new EvaluationRepository($this->semester);
        return $repo->fetch($grade);
    }
}

/**
 * Entity, Repository, Model,
 * 
 * Entity => just one record
 * EvaluationEntity
 *  [ StudentId, SittingNumber, .... ]
 * PracticalEntity
 *  [ StudentId, SittingNumber, .... ]
 * WrittenEntity
 *  [ StudentId, SittingNumber, .... ]
 * 
 * Repository
 *  
 * MonitoringRepository
 */
