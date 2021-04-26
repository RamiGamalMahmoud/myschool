<?php

namespace SM\Controllers;

use Simple\Contracts\ErrorHandlerInterface;
use Simple\Core\IErrorHandler;
use Simple\Core\View;

class ErrorController implements ErrorHandlerInterface
{
    private array $context;
    private string $template = 'errors/error.twig';

    public function render()
    {
        View::render($this->template, $this->context);
    }

    public function internalError()
    {
        $this->context = [
            'code' => 500,
            'message' => 'internal server error',
            'description' => 'we are sorry, this is an internal server error'
        ];
        http_response_code(500);
        $this->render();
        exit;
    }

    public function pageNotFound($message = '', $description = '')
    {
        $this->context = [
            'code' => 404,
            'message' => $message === '' ? 'page not found' : $message,
            'description' => $description === '' ? 'you are trying to visit page that not exist' : $description
        ];
        http_response_code(404);
        $this->render();
        exit;
    }

    public function resourcesRemoved()
    {
        $this->context = [
            'code' => 410,
            'message' => 'page not found',
            'description' => 'sorry, the resources you requested has been deleted'
        ];
        http_response_code(410);
        $this->render();
        exit;
    }

    public function authorizationError()
    {
        $this->context = [
            'code' => 401,
            'message' => 'authorization failed',
            'description' => 'you are not authorized to access this url'
        ];
        http_response_code(401);
        $this->render();
        exit;
    }

    public function api()
    {
        http_response_code(404);
        echo 'request url not exists';
        exit;
    }
}
