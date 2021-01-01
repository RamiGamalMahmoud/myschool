<?php

namespace SM\Repos\Exams\Monitoring;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Entities\Entity;
use SM\Repos\IRepo;

abstract class AbstractMonitoringRepo implements IRepo
{

    protected IDataAccess $dataAccess;
    protected string $dbTable;
    protected int $gradeNumber;

    public abstract function __construct(string $semester, int $gradeNumber, IDataAccess $dataAccess);

    public function save($studentId, $dataName, $dataValue)
    {
        $query = new Query();
        $degree = -1;
        if (is_numeric($dataValue)) {
            $degree = $dataValue;
        }

        $query->selectCount('studentId')
            ->from($this->dbTable)
            ->where('studentId', '=', $studentId);
        $entity = new Entity(['studentId' => $studentId, $dataName => $degree]);
        if ($this->dataAccess->get($query)['count'] > 0) {
            return $this->edit($entity);
        } else {
            return $this->create($entity);
        }
    }

    protected function extractData(Entity $entity): array
    {
        $data = $entity->getData();

        $studentId = array_shift($data);
        $dataName = array_key_first($data);
        $dataValue = $data[$dataName];
        $result = ['studentId' => $studentId, 'dataName' => $dataName, 'dataValue' => $dataValue];
        return $result;
    }



    public function create(Entity $entity)
    {
        $data = $this->extractData($entity);

        $query = new Query();
        $query->insertInto($this->dbTable)
            ->values(['studentId' => $data['studentId'], $data['dataName'] => $data['dataValue']]);
        return $this->dataAccess->run($query);
    }

    public function edit(Entity $entity)
    {
        $data = $this->extractData($entity);
        $query = new Query();
        $query->update($this->dbTable)
            ->set([$data['dataName'] => $data['dataValue']])
            ->where('studentId', '=', $data['studentId']);
        return $this->dataAccess->run($query);
    }
}
