<?php

namespace SM\Repos\EmployeesAffairs\JobData;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Entities\EmployeesAffairs\PresenceStatus;

class PresenceStatusRepo implements IPresenceStatusRepo
{
    private IDataAccess $dataAccess;

    private string $table = 'presence_status';

    private array $columns = ['id', 'presence_status'];

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getById($id): PresenceStatus
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->where('id', '=', $id);
        $status = $this->dataAccess->get($query);
        return new PresenceStatus($status['id'], $status['presence_status']);
    }

    public function getAll(): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table);
        $data = $this->dataAccess->getAll($query);

        $allPresenceStatus = array_map(function ($status) {
            return new PresenceStatus($status['id'], $status['presence_status']);
        }, $data);
        return $allPresenceStatus;
    }

    public function update($id, $status)
    {
    }

    public function create($id, $status)
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
