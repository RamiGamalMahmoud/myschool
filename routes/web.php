<?php

use Simple\Core\Route;
use SM\Controllers\Logout;
use SM\Controllers\IndexController;
use SM\Controllers\Admin\AdminController;
use SM\Controllers\EmployeesAffairs\EmployeesAffairsController;
use SM\Controllers\Exams\Certificates\CertificatesController;
use SM\Controllers\Exams\ExamsController;
use SM\Controllers\Exams\MonitoringController;
use SM\Controllers\Exams\Sheets\SheetsController;
use SM\Controllers\LoginController;
use SM\Controllers\Users\UserController;
use SM\MiddleWares\Auth;

/**
 * GET ROUTES
 */
Route::get('login', [LoginController::class, 'showLogin']);

Route::get('logout', [Logout::class, 'logout']);

Route::get('/', [IndexController::class, 'index'], ['isAuthenticated']);

Route::get('admin', [AdminController::class, 'index'], ['isAuthenticated', 'authorize']);

Route::get('admin/users', [UserController::class, 'index']);

Route::get('admin/users/edit/{id}', [UserController::class, 'edit']);

Route::get('admin/users/delete/{id}', [UserController::class, 'remove']);

Route::get('admin/users/block/{id}', [UserController::class, 'blockUser']);

Route::get('employees-affairs', [EmployeesAffairsController::class, 'index']);

Route::get('employees-affairs/show-all/{criteria}/{value}', [EmployeesAffairsController::class, 'getBy']);

Route::get('employees-affairs/edit/{id}', [EmployeesAffairsController::class, 'edit']);

Route::get('exams', [ExamsController::class, 'index']);

Route::get('exams/{gradeNumber}', [ExamsController::class, 'index']);

Route::get('monitoring/{gradeNumber}/{monitoringType}/{semester}', [MonitoringController::class, 'index']);

Route::get('sheets/{gradeNumber}/{semester}/{status}', [SheetsController::class, 'index']);

Route::get('certificates/{gradeNumber}/{semester}/{status}',  [CertificatesController::class, 'index']);

/**
 * POST ROUTES
 */
Route::post('login', [LoginController::class, 'doLogin']);

Route::post('admin/users/edit/{id}', [UserController::class, 'update']);

Route::post('employees-affairs/edit/{id}', [EmployeesAffairsController::class, 'update']);

Route::post('monitoring/{gradeNumber}/{monitoringType}/{semester}', [MonitoringController::class, 'store']);

/**
 * MIDDLEWARE ROUTES
 */
Route::middleware('isAuthenticated', [Auth::class, 'isAuthenticated']);

Route::middleware('authorize', [Auth::class, 'authorize']);
