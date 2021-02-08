<?php

use Simple\Core\View;
use SM\Helpers\Translate;
use Simple\Helpers\Config;
use Simple\Core\DataAccess\MySQLAccess;
use Simple\Core\Router;

require_once '../config/init.php';
require_once '../config/config.php';

require_once '../vendor/autoload.php';

$database_config = require_once(DB_CONFIG);

Config::load(CONFIG_DIR);

Router::setRoutesDirectory(ROUTES_FOLDER);

MySQLAccess::config($database_config[DATABASE_DRIVER]);

MySQLAccess::connect();

Translate::init(require_once '../resources/locals/ar.php');

View::init(VIEWS_PATH, COMPILE_PATH, VIEWS_AUTO_RELOAD);
