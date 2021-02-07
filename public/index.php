<?php

use Simple\Core\Simple;
use SM\Controllers\ErrorController;
use Simple\Exceptions\RouterException;
use SM\Exceptions\AuthorizationException;
use Simple\EXceptions\MethodNotFoundException;
use Simple\EXceptions\ControllerNotFoundException;

require_once '../bootstrap/bootstrap.php';

Simple::init(ROUTES_FOLDER);

try {
    Simple::run();
} catch (RouterException $e) {
    ErrorController::pageNotFound();
} catch (AuthorizationException $exception) {
    ErrorController::authorizationError();
} catch (ControllerNotFoundException $exception) {
    ErrorController::pageNotFound();
} catch (MethodNotFoundException $exception) {
    ErrorController::pageNotFound();
}
