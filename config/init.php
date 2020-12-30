<?php

if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

/**
 * THE APPLICATION ROOT
 */
define('ROOT', str_replace('/', DS, dirname($_SERVER['DOCUMENT_ROOT'])) . DS);

/**
 * THE APPLICATION SROUCE DIRECTORY
 */
define('APP_PATH', ROOT . 'src' . DS);

/**
 * THE TEMPLATES PATH
 */
define('VIEWS_PATH', ROOT . DS . 'resources' . DS . 'templates');

/**
 * CONFIGRATIONS DRIECTORY
 */
define('CONFIG_DIR', ROOT . 'config');

/**
 * TEMPLATES COMPILATION DIRECTORY
 */
define('COMPILE_PATH', ROOT . 'storage' . DS . 'templates_c');

/**
 * THE MAIN CONFIGRATION FILE PATH
 */
define('CONFIG_FILE', CONFIG_DIR . DS . 'config.php');

/**
 * THE ROUTES DIRECTORY
 */
define('ROUTES_FOLDER', CONFIG_DIR . DS . 'routes' . DS);

/**
 * THE WEB ROUTES FILE
 */
define('WEB_ROUTES', CONFIG_DIR . DS . 'routes' . DS . 'web.php');

/**
 * THE API ROUTES FILE
 */
define('API_ROUTES', CONFIG_DIR . DS . 'routes' . DS . 'api.php');

define('ROUTES', ROOT . DS . 'config' . DS . 'routes' . DS . 'routes.php');

/**
 * DEGRESS SETTINGS FILE
 */
define('FS_DEGS_SETTINGS', CONFIG_DIR . DS . 'subjects-degs' . DS . 'fs-degs-settings.php');

/**
 * DATABASE CONFIGRATIONS FILE
 */
define('DB_CONFIG', CONFIG_DIR . DS . 'database.php');

/**
 * TRENSLATIONS DIRECTORY
 */
define('RENSLATIONS_DIRECTORY', ROOT . DS . 'langs' . DS);

/**
 * NAMESPACES
 */

define('CONTROLLRES', 'SM\\Controllers\\');
