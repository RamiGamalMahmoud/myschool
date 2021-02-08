<?php

use Simple\Core\Application;
use SM\Controllers\ErrorController;

require_once '../bootstrap/bootstrap.php';

Application::init(new ErrorController());

Application::run();
