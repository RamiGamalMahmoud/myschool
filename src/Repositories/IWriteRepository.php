<?php

namespace SM\Repositories;

use SM\Entities\BaseEntity;

interface IWriteRepository
{
    public function findById($id);

    public function save(BaseEntity $e);

    public function update(BaseEntity $e, string $dataName);

    public function remove(BaseEntity $e);
}