<?php

use Simple\Core\Simple;
use Simple\Exceptions\RouterException;
use SM\Controllers\ErrorController;
use SM\Exceptions\AuthorizationException;

require_once '../bootstrap/bootstrap.php';

Simple::init(ROUTES_FOLDER);

try {
    Simple::run();
} catch (RouterException $e) {
    ErrorController::pageNotFound();
} catch (AuthorizationException $exception) {
    ErrorController::authorizationError();
}
