<?php

namespace SM\Controllers\Address;

use Simple\Core\DataAccess\MySQLAccess;
use Simple\Core\Request;
use Simple\Core\Router;
use SM\Services\Address\AddressService;

class AddressController
{
    /**
     * @var \Simple\Core\Request
     */
    private Request $request;

    /**
     * @var \Simple\Core\Router
     */
    private Router $router;

    /**
     * @var \SM\Services\Address\AddressService
     */
    private AddressService $addressService;

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;
        $this->addressService = new AddressService(new MySQLAccess());
    }

    public function getCitiesByGovernorateId()
    {
        $governorateId = $this->router->get('governorate');
        $cities = $this->addressService->getCitiesByGovernorate($governorateId);
        $data = json_encode($cities);
        header('Content-Type: application/json');
        echo $data;
    }
}
