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

Route::get('admin/{other}/*.*', CONTROLLRES . 'Admin\\AdminController@reRoute');

Route::get('users', CONTROLLRES . 'Users\\UsersController@index');

/**
* EXAMS HTTP GET ROUTES
*/

Route::get('exams', CONTROLLRES . 'Exams\\ExamsController@index');

Route::get('exams/\d*', CONTROLLRES . 'Exams\\ExamsController@index');

Route::get('exams/\d*/{section}/*.*', CONTROLLRES . 'Exams\\ExamsController@reRoute');

Route::get('monitoring/{table}/{semester}', CONTROLLRES . 'Exams\\MonitoringController@index');

/**
 * HTTP POST METHOD ROUTES
 */

Route::post('login', CONTROLLRES . 'Login@authenticate');

### Admin Routes

Route::post('admin/{other}/*.*', CONTROLLRES . 'Admin\\AdminController@reRoute');

### Exams Routes

Route::post('exams/\d*/{section}/*.*', CONTROLLRES . 'Exams\\ExamsController@reRoute');

Route::post('monitoring/{table}/{semester}', CONTROLLRES . 'Exams\\MonitoringController@save');

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
