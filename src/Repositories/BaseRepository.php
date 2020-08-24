<?php

namespace SM\Repositories;

use Simple\Helpers\DB;
use SM\Entities\BaseEntity;

abstract class BaseRepository
{
    protected DB $db;
    protected string $table;
    protected array $fields;

    public abstract function fetch($grade): array;

    public abstract function findById($id);

    public abstract function save(BaseEntity $e);

    public abstract function update(BaseEntity $e, string $dataName);

    public abstract function remove(BaseEntity $e);
}