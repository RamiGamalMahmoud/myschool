<?php


namespace SM\Objects\Address;

class Address
{
    private City $city;

    private Governorate $governorate;

    private ?string $district;

    private ?string $street;

    public function __construct(Governorate $governorate, City $city, ?string $district, ?string $street)
    {
        $this->city = $city;
        $this->governorate = $governorate;
        $this->district = $district;
        $this->street = $street;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getGovernorate()
    {
        return $this->governorate;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function getStreet()
    {
        return $this->street;
    }

    public function getFullAddress()
    {
        return $this->governorate->getGovernorateName() .
            ' ' .
            $this->city->getCityName() .
            ' ' .
            $this->district .
            ' ' .
            $this->street;
    }

    public function toArray(): array
    {
        return [
            'governorate' => $this->getGovernorate()->toArray(),
            'city' => $this->getCity()->toArray(),
            'district' => $this->getDistrict(),
            'street' => $this->getStreet()
        ];
    }
}
