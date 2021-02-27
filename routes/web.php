<?php

use Simple\Core\Route;
use SM\MiddleWares\Auth;
use SM\Controllers\Logout;
use SM\Controllers\IndexController;
use SM\Controllers\LoginController;
use SM\Controllers\Users\UserController;
use SM\Controllers\Admin\AdminController;
use SM\Controllers\Exams\ExamsController;
use SM\Controllers\Address\AddressController;
use SM\Controllers\Exams\MonitoringController;
use SM\Controllers\Exams\Sheets\SheetsController;
use SM\Controllers\Exams\Certificates\CertificatesController;
use SM\Controllers\EmployeesAffairs\EmployeesAffairsController;
use SM\Controllers\StudentsAffairs\AbsenceController;
use SM\Controllers\StudentsAffairs\StudentAbsenceController;
use SM\Controllers\StudentsAffairs\StudentDataController;
use SM\Controllers\StudentsAffairs\StudentsAffairsController;

/**
 * GET ROUTES
 */
Route::get('login', [LoginController::class, 'showLogin']);

Route::get('logout', [Logout::class, 'logout']);

Route::get('/', [IndexController::class, 'index']);

Route::get('admin', [AdminController::class, 'index'], ['isAuthenticated', 'authorize']);

Route::get('admin/users', [UserController::class, 'index']);

Route::get('admin/users/edit/{id}', [UserController::class, 'edit']);

Route::get('admin/users/delete/{id}', [UserController::class, 'remove']);

Route::get('admin/users/block/{id}', [UserController::class, 'blockUser']);

Route::get('employees-affairs', [EmployeesAffairsController::class, 'index']);

Route::get('employees-affairs/search', [EmployeesAffairsController::class, 'search']);

Route::get('employees-affairs/show/{present_status}', [EmployeesAffairsController::class, 'index']);

Route::get('employees-affairs/filter/{filter_type}/{criteria}/{value}', [EmployeesAffairsController::class, 'getBy']);

Route::get('employees-affairs/edit/{id}', [EmployeesAffairsController::class, 'edit']);

Route::get('exams', [ExamsController::class, 'index']);

Route::get('exams/{gradeNumber}', [ExamsController::class, 'index']);

Route::get('monitoring/{gradeNumber}/{monitoringType}/{semester}', [MonitoringController::class, 'index']);

Route::get('sheets/{gradeNumber}/{semester}/{status}', [SheetsController::class, 'index']);

Route::get('certificates/{gradeNumber}/{semester}/{status}', [CertificatesController::class, 'index']);

######################################## STUDENTS AFFAIRS ##############################################################

Route::get(
    'students-affairs',
    [StudentsAffairsController::class, 'index']
);

Route::get(
    'students-affairs/students-data/show-all',
    [StudentDataController::class, 'showAll']
);

Route::get(
    'students-affairs/students-data/show/{gradeNumber}',
    [StudentDataController::class, 'showByGradeNumber']
);

Route::get(
    'students-affairs/students-data/show/{gradeNumber}/{classNumber}',
    [StudentDataController::class, 'showByClassNumber']
);

Route::get(
    'students-affairs/absence/show/{gradeNumber}',
    [StudentAbsenceController::class, 'showGradeAbsenceRegistrationTable']
);

Route::get(
    'students-affairs/absence/show/{gradeNumber}/{classNumber}',
    [StudentAbsenceController::class, 'showClassAbsenceRegistrationTable']
);

/**
 * POST ROUTES
 */
Route::post('login', [LoginController::class, 'doLogin']);

Route::post('admin/users/edit/{id}', [UserController::class, 'update']);

Route::post('employees-affairs/edit/{id}', [EmployeesAffairsController::class, 'update']);

Route::post('monitoring/{gradeNumber}/{monitoringType}/{semester}', [MonitoringController::class, 'store']);

Route::get('adderss/cities/by-governorate/{governorate}', [AddressController::class, 'getCitiesByGovernorateId']);

Route::post(
    'students-affairs/absence/register/{studentId}',
    [StudentAbsenceController::class, 'registerStudentAbsence']
);

/**
 * MIDDLEWARE ROUTES
 */
Route::middleware('isAuthenticated', [Auth::class, 'isAuthenticated']);

Route::middleware('authorize', [Auth::class, 'authorize']);
