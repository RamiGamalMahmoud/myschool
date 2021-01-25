<?php

use Simple\Core\Simple;
use Simple\Exceptions\RouterException;
use SM\Controllers\ErrorController;

require_once '../bootstrap/bootstrap.php';

Simple::init(ROUTES_FOLDER);

try {
    Simple::run();
} catch (RouterException $e) {
    ErrorController::resourcesRemoved();
}
