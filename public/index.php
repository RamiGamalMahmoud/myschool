<?php

use Simple\Core\Simple;

require_once('../config/config.php');
require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = new Simple();

$app->run();

