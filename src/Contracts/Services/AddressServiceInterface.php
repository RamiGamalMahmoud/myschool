<?php

namespace SM\Contracts\Services;

interface AddressServiceInterface
{
    public function getGovernorates();
    public function getCitiesByGovernorate($governorateId): array;
}
