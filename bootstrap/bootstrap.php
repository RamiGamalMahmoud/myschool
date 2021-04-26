<?php

use SM\Controllers\ErrorController;
use Simple\Core\Application;
use Simple\Helpers\Log;
use SM\Helpers\Translate;

require_once '../vendor/autoload.php';

Translate::init(require_once '../resources/locals/ar.php');

$app = Application::getInstance(dirname(__DIR__));

$app->setErrorHandler(new ErrorController());

$app->run(true);
