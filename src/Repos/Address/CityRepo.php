<?php

namespace SM\Repos\Address;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Objects\Address\City;

class CityRepo
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
    private array $columns = ['id', 'city_name'];

    /**
     * Construtor
     * 
     * @param \Simple\Core\DataAccess\IDataAccess $dataAccess
     */
    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
        $this->table = 'city';
    }

    /**
     * Gets all cities
     * 
     * @return array
     */
    public function getAll(): array
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->orderBy(['city_name']);
        $cities = $this->dataAccess->getAll($query);
        $cities = array_map(function ($city) {
            return new City($city['id'], $city['city_name']);
        }, $cities);
        return $cities;
    }

    /**
     * Search for a city by id
     * 
     * @param $id
     * @return \SM\Objects\Address\City
     */
    public function getById($id): City
    {
        $query = new Query();
        $query->select($this->columns)
            ->from($this->table)
            ->where('id', '=', $id);
        $city = $this->dataAccess->get($query);
        return new City($city['id'], $city['name']);
    }

    /**
     * Gets all cities by governorate id
     * 
     * @param $governorateId
     * @return array
     */
    public function getAllByGovernorateId($governorateId)
    {
        $columns = [
            'city.id',
            'city.city_name'
        ];
        $query = new Query();
        $query->select($columns)
            ->from($this->table)
            ->join('governorate')
            ->on($this->table . '.governorate_id', 'governorate.id')
            ->where($this->table . '.governorate_id', '=', $governorateId)
            ->orderBy([$this->table . '.city_name']);
        $data = $this->dataAccess->getAll($query);
        $cities = array_map(function ($city) {
            return new City($city['id'], $city['city_name']);
        }, $data);
        return $cities;
    }
}
