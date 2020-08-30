<?php

namespace SM\Controllers;

use Simple\Core\IRequest;

abstract class BaseController
{
    /**
     * @var array $context Array represents the data that will be used in the view template
     */
    protected ?array $context;

    /**
     * @var mixed $model 
     */
    protected $model;

    /**
     * @var Simple\Core\Request $request 
     */
    protected IRequest $request;

    /**
     * @var string $view The template file
     */
    protected $view;

    public function __construct(IRequest $request, $params = null)
    {
        $this->request = $request;
        $this->context = $params;
    }

    public abstract function index();
    public abstract function render(array $context);

}