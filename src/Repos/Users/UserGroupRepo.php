<?php

namespace SM\Repos\Users;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;

class UserGroupRepo implements UserGroupRepoInterface
{
    private IDataAccess $dataAccess;

    private array $columns;

    private string $table;

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->columns = ['id', 'group_name'];
        $this->table = 'groups';
    }

    public function getAll()
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->orderBy(['id', 'group_name']);
        return $this->dataAccess->getAll($query);
    }

    public function addGroup()
    {
    }

    public function editGroup()
    {
    }

    public function updateGroup()
    {
    }
}
