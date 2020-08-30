<?php

namespace SM\Controllers\Exams;

use Simple\Core\IRequest;
use Simple\Core\Request;
use SM\Models\Exams\Monitoring\IMonitoringModel;
use Simple\Helpers\Functions;

abstract class BaseExamsController
{
    /**
     * @var array $context Array represents the data that will be used in the view template
     */
    protected ?array $context;

    /**
     * @var mixed $model 
     */
    protected IMonitoringModel $model;

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