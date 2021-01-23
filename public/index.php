<?php

use Simple\Core\Simple;
use Simple\Exceptions\RoutingException;

require_once '../bootstrap/bootstrap.php';

Simple::init(ROUTES_FOLDER);

try {
    Simple::run();
} catch (RoutingException $e) {
    header('location: /error');
}
