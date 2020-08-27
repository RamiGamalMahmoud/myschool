<?php

namespace SM\Controllers;

use Simple\Core\Request;

abstract class BaseController
{
    /**
     * @var array $context Array represents the data that will be used in the view template
     */
    protected array $context;

    /**
     * @var mixed $model 
     */
    protected $model;

    /**
     * @var Simple\Core\Request $request 
     */
    protected Request $request;

    /**
     * @var string $view The template file
     */
    protected $view;

    public abstract function index();
    public abstract function render(array $context);

}