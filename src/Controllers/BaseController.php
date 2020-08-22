<?php

namespace SM\Controllers;

use SM\Models\IModel;
use Simple\Core\Request;

abstract class BaseController
{
    protected $view;
    protected Request $request;
    protected IModel $model;

    public abstract function render(array $context);
}