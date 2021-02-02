<?php

namespace SM\Repos\Address;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Objects\Address\Governorate;

class GovernorateRepo
{
    /**
     * @var string $table
     */
    private $table;

    /**
     * @var \Simple\Core\DataAccess\IDataAccess $dataAccess
     */
    private IDataAccess $dataAccess;

    /**
     * @var array $columns
     */
    private array $columns = ['id', 'governorate_name'];

    /**
     * Construtor
     * 
     * @param \Simple\Core\DataAccess\IDataAccess $dataAccess
     */
    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->table = 'governorate';
    }

    /**
     * Gets all governorates
     * 
     * @return array
     */
    public function getAll(): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->orderBy(['governorate_name']);
        $governorates = $this->dataAccess->getAll($query);
        $governorates = array_map(function ($governorate) {
            return new Governorate($governorate['id'], $governorate['governorate_name']);
        }, $governorates);
        return $governorates;
    }

    /**
     * Search for a governorate by id
     * 
     * @param $id
     * @return \SM\Objects\Address\Governorate
     */
    public function getById($id): Governorate
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->where('id', '=', $id);
        $governorate = $this->dataAccess->get($query);
        return new Governorate($governorate['id'], $governorate['name']);
    }
}
