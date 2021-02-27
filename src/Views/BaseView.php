<?php

namespace SM\Views;

use Simple\Core\View;

abstract class BaseView
{
    protected array $contextData;

    protected string $template;

    public function addToContextData($name, $data)
    {
        $this->contextData[$name] = $data;
    }

    public function render()
    {
        View::render($this->template, $this->contextData);
    }

    public function setContextData(array $data)
    {
        $this->contextData = $data;
    }
}
