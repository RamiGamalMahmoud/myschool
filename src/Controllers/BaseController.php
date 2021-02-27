<?php

namespace SM\Controllers;

use Simple\Core\Request;
use Simple\Core\Router;

abstract class BaseController
{
    /**
     * @var \Simple\Core\Request
     */
    protected Request $request;

    /**
     * @var \Simple\Core\Router
     */
    protected Router $router;

    public function __construct(Request $request, Router $router)
    {
        $this->request = $request;
        $this->router = $router;
    }
}
