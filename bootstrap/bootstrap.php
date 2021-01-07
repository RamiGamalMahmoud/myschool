<?php

use Simple\Core\View;
use SM\Helpers\Translator;

require_once('../config/init.php');
require_once('../config/config.php');

require_once '../vendor/autoload.php';

Translator::init(require_once '../resources/locals/ar.php');

View::init(VIEWS_PATH, COMPILE_PATH, VIEWS_AUTO_RELOAD);
