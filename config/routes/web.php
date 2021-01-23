<?php

use Simple\Core\Request;
use Simple\Core\Route;
use SM\Controllers\Error;
use SM\Controllers\Login;
use SM\Controllers\Logout;
use SM\Controllers\IndexController;
use SM\Controllers\Admin\AdminController;
use SM\Controllers\Exams\Certificates\CertificatesController;
use SM\Controllers\Exams\ExamsController;
use SM\Controllers\Exams\MonitoringController;
use SM\Controllers\Exams\Sheets\SheetsController;
use SM\Controllers\Users\UsersController;
use SM\MiddleWares\Auth;

/**
 * HTTP GET METHOD ROUTES
 */

Route::get('login', [Login::class, 'login']);

Route::get('logout', [Logout::class, 'logout']);

Route::get('error', [Error::class, 'error']);

Route::get('/', [IndexController::class, 'index'], ['isAuthenticated']);


Route::get('admin', [AdminController::class, 'index'], ['isAuthenticated', 'authorize']);

Route::get('admin/{other}/*.*', [AdminController::class, 'reRoute']);

Route::get('users', [UsersController::class, 'index']);

/**
 * EXAMS HTTP GET ROUTES
 */

Route::get('exams', [ExamsController::class, 'index']);

Route::get('exams/\d*', [ExamsController::class, 'index']);

Route::get('exams/\d*/{section}/*.*', [ExamsController::class, 'reRoute']);

Route::get('monitoring/{table}/{semester}', [MonitoringController::class, 'index']);

Route::get('sheets/{semester}/{status}', [SheetsController::class, 'index']);

Route::get('certificates/{semester}/{status}',  [CertificatesController::class, 'index']);

/**
 * HTTP POST METHOD ROUTES
 */

Route::post('login', [Login::class, 'authenticate']);

### Admin Routes

Route::post('admin/{other}/*.*', [AdminController::class, 'reRoute']);

### Exams Routes

Route::post('exams/\d*/{section}/*.*', [ExamsController::class, 'reRoute']);

Route::post('monitoring/{table}/{semester}', [ExamsController::class, 'save']);

/**
 * MIDDLEWARES ROUTES
 */

Route::middleware('isAuthenticated', [Auth::class, 'isAuthenticated']);

Route::middleware('authorize', [Auth::class, 'authorize']);

/**
 * CALLABLE ROUTES
 */


/**
 * VIEWS ROUTES
 */
