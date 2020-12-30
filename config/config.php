<?php

if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

define('ROOT', str_replace('/', DS, dirname($_SERVER['DOCUMENT_ROOT'])) . DS);

define('APP_PATH', ROOT . 'src' . DS);

define('VIEWS_PATH', ROOT . DS . 'resources' . DS . 'templates');

define('CONFIG_DIR', ROOT . 'config');

define('COMPILE_PATH', ROOT . 'storage' . DS . 'templates_c');

define('CONFIG_FILE', CONFIG_DIR . DS . 'config.php');

define('ROUTES_FOLDER', CONFIG_DIR . DS . 'routes' . DS);

define('WEB_ROUTES', CONFIG_DIR . DS . 'routes' . DS . 'web.php');

define('API_ROUTES', CONFIG_DIR . DS . 'routes' . DS . 'api.php');

define('ROUTES', ROOT . DS . 'config' . DS . 'routes' . DS . 'routes.php');

define('VIEWS_AUTO_RELOAD', true);

define('FS_DEGS_SETTINGS', CONFIG_DIR . DS . 'subjects-degs' . DS . 'fs-degs-settings.php');

define('DB_CONFIG', CONFIG_DIR . DS . 'database.php');

/**
 * NAMESPACES
 */

define('CONTROLLRES', 'SM\\Controllers\\');
