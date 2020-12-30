<?php

use Simple\Core\Simple;
use Simple\Core\View;

require_once('../config/init.php');
require_once('../config/config.php');

require_once dirname(__DIR__) . '/vendor/autoload.php';

View::init(VIEWS_PATH, COMPILE_PATH, VIEWS_AUTO_RELOAD);

$app = new Simple(ROUTES_FOLDER);

$app->run();
