<?php

namespace SM\Services\Address;

use Simple\Core\DataAccess\MySQLAccess;
use SM\Repos\Address\CityRepo;
use SM\Repos\Address\GovernorateRepo;

class AddressService
{
    private GovernorateRepo $governorateRepo;

    private CityRepo $cityRepo;

    public function __construct()
    {
        $dataAccess = new MySQLAccess();
        $this->governorateRepo = new GovernorateRepo($dataAccess);
        $this->cityRepo = new CityRepo($dataAccess);
    }

    public function getGovernorates()
    {
        $data = $this->governorateRepo->getAll();
        $governorates = array_map(function ($governorate) {
            return $governorate->toArray();
        }, $data);
        return $governorates;
    }

    public function getCitiesByGovernorate($governorateId): array
    {
        $data = $this->cityRepo->getAllByGovernorateId($governorateId);
        $cities = array_map(function ($city) {
            return $city->toArray();
        }, $data);
        return $cities;
    }
}
