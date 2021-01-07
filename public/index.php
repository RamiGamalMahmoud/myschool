<?php

use Simple\Core\Simple;

require_once '../bootstrap/bootstrap.php';

$app = new Simple(ROUTES_FOLDER);

$app->run();
