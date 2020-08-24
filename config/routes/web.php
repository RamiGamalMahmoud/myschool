<?php

use Simple\Core\Route;

/**
 * HTTP GET METHOD ROUTES
 */

Route::get('login', CONTROLLRES . 'Login@login');

Route::get('logout', CONTROLLRES . 'Logout@logout');

Route::get('error', CONTROLLRES . 'Error@error');

Route::get('/', CONTROLLRES . 'IndexController@index', ['isAuthenticated']);


Route::get('admin', CONTROLLRES . 'Admin\\AdminController@index', ['isAuthenticated', 'authorize']);

Route::get('admin/users', CONTROLLRES . 'Admin\\AdminController@showUsers', ['isAuthenticated', 'authorize']);

Route::get('admin/exams', CONTROLLRES . 'Admin\\AdminController@exams', ['isAuthenticated', 'authorize']);

Route::get('admin/exams/\d*', CONTROLLRES . 'Admin\\AdminController@exams', ['isAuthenticated', 'authorize']);

Route::get('admin/exams/\d*/{table}/{semester}', CONTROLLRES . 'Admin\\AdminController@exams', ['isAuthenticated', 'authorize']);

/**
* EXAMS HTTP GET ROUTES
*/

Route::get('exams', CONTROLLRES . 'Exams\\ExamsController@index');

Route::get('exams/\d*', CONTROLLRES . 'Exams\\ExamsController@view');

Route::get('exams/\d*/{table}/{semester}', CONTROLLRES . 'Exams\\ExamsController@monitoring');


/**
 * HTTP POST METHOD ROUTES
 */

Route::post('login', CONTROLLRES . 'Login@authenticate');

### Admin Routes

Route::post('admin/students/save/\d*', CONTROLLRES . 'StudenstController@saveNewStudent');

Route::post('admin/exams/\d*/{table}/{semester}', CONTROLLRES . 'Admin\\AdminController@exams');

### Exams Routes

Route::post('exams/\d*/{table}/{semester}', CONTROLLRES . 'Exams\\ExamsController@save');


/**
 * MIDDLEWARES ROUTES
 */

Route::middleware('isAuthenticated', 'SM\\MiddleWares\\Auth@isAuthenticated');

Route::middleware('authorize', 'SM\\MiddleWares\\Auth@authorize');

/**
 * CALLABLE ROUTES
 */


/**
 * VIEWS ROUTES
 */
