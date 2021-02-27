<?php

namespace SM\Repos;

use Simple\Core\DataAccess\IDataAccess;

abstract class BaseRepo
{
    /**
     * @var \Simple\Core\DataAccess\IDataAccess
     */
    protected IDataAccess $dataAccess;

    /**
     * @var string
     */
    protected string $table;

    public function __construct(IDataAccess $dataAccess, string $table)
    {
        $this->dataAccess = $dataAccess;
        $this->table = $table;
    }
}
