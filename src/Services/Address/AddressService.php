<?php

namespace SM\Services\Address;

use Simple\Core\DataAccess\IDataAccess;
use Simple\Core\DataAccess\Query;
use SM\Objects\Address\Governorate;
use SM\Repos\Address\CityRepo;
use SM\Repos\Address\GovernorateRepo;

class AddressService
{
    private GovernorateRepo $governorateRepo;

    private CityRepo $cityRepo;

    private IDataAccess $dataAccess;

    public function __construct(IDataAccess $dataAccess)
    {
        $this->dataAccess = $dataAccess;
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
