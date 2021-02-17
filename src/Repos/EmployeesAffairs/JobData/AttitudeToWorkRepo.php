<?php

namespace SM\Repos\EmployeesAffairs\JobData;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Entities\EmployeesAffairs\AttitudeToWork;

class AttitudeToWorkRepo implements IAttitudeToWorkRepo
{
    private IDataAccess $dataAccess;

    private string $table = 'attitude_to_work';

    private array $columns = ['id', 'attitude'];

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getById($id): AttitudeToWork
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->where('id', '=', $id);
        $attitude = $this->dataAccess->get($query);
        return new AttitudeToWork($attitude['id'], $attitude['attitude']);
    }

    public function getAll(): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table);
        $data = $this->dataAccess->getAll($query);
        $attitudes = array_map(function ($attitude) {
            return new AttitudeToWork($attitude['id'], $attitude['attitude']);
        }, $data);
        return $attitudes;
    }

    public function update($id, $attitude)
    {
    }

    public function create($id, $attitude)
    {
    }

    public function remove($id)
    {
        $query = new Query();
        $query->delete()
            ->from($this->table)
            ->where('id', '=', $id);
        return $this->dataAccess->run($query);
    }
}
