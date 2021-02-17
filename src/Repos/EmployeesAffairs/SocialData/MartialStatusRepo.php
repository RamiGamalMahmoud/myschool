<?php

namespace SM\Repos\EmployeesAffairs\SocialData;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Entities\EmployeesAffairs\MartialStatus;

class MartialStatusRepo implements IMartialStatusRepo
{
    private IDataAccess $dataAccess;

    private string $table = 'martial_status';

    private array $columns = ['id', 'martial_status'];

    /**
     * Constructor
     */
    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function getById($id)
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->where('id', '=', $id);
        $martial = $this->dataAccess->get($query);
        return new MartialStatus($martial['id'], $martial['martial_status']);
    }

    public function getAll()
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table);
        $data = $this->dataAccess->getAll($query);
        $martials = array_map(function ($martial) {
            return new MartialStatus($martial['id'], $martial['martial_status']);
        }, $data);
        return $martials;
    }

    public function update($id, $martialStatus)
    {
    }

    public function create($martialStatus)
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
