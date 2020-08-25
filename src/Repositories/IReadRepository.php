<?php

namespace SM\Repositories;

interface IReadRepository
{
    public function fetch($grade): array;

    public function findById($id);
}